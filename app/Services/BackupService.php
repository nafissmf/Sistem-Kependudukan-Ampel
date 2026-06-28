<?php

namespace App\Services;

use App\Models\DatabaseBackup;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Backup & Restore database (Phase 6), sesuai dokumen "BACKUP DATABASE".
 *
 * Pendekatan: shell exec `mysqldump`/`mysql` lewat Symfony Process (sudah
 * jadi dependency inti Laravel, tidak perlu composer package tambahan).
 * Ini pendekatan paling portable untuk MySQL — TIDAK memakai paket pihak
 * ketiga seperti spatie/laravel-backup supaya lebih mudah diaudit & tidak
 * menambah permukaan dependency yang harus dipercaya.
 *
 * PRASYARAT: binary `mysqldump` dan `mysql` harus ada di PATH server.
 * Kalau hosting tidak menyediakan shell exec (banyak shared hosting
 * membatasi ini), fitur ini tidak akan berfungsi — solusinya di
 * lingkungan seperti itu adalah backup lewat tool bawaan hosting/cPanel.
 */
class BackupService
{
    private const DISK = 'local';

    private const DIRECTORY = 'backups';

    public function create(?string $actorUserId = null): DatabaseBackup
    {
        $connection = config('database.default');
        $config = config("database.connections.{$connection}");

        if ($config['driver'] !== 'mysql') {
            throw new RuntimeException('Backup otomatis saat ini hanya mendukung MySQL.');
        }

        $filename = 'sik-ampel-'.now()->format('Ymd-His').'.sql';
        $fullPath = Storage::disk(self::DISK)->path(self::DIRECTORY.'/'.$filename);

        Storage::disk(self::DISK)->makeDirectory(self::DIRECTORY);

        $process = new Process([
            'mysqldump',
            '-h', $config['host'],
            '-P', (string) $config['port'],
            '-u', $config['username'],
            '--single-transaction',
            '--no-tablespaces',
            '--result-file='.$fullPath,
            $config['database'],
        ], env: ['MYSQL_PWD' => $config['password']]);

        $process->setTimeout(300);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return DatabaseBackup::create([
            'filename' => $filename,
            'size' => filesize($fullPath) ?: 0,
            'storage' => self::DISK,
            'created_by' => $actorUserId,
        ]);
    }

    public function restore(DatabaseBackup $backup): void
    {
        $connection = config('database.default');
        $config = config("database.connections.{$connection}");
        $fullPath = Storage::disk(self::DISK)->path(self::DIRECTORY.'/'.$backup->filename);

        if (! file_exists($fullPath)) {
            throw new RuntimeException('File backup tidak ditemukan di server.');
        }

        $process = Process::fromShellCommandline(
            'mysql -h '.escapeshellarg($config['host']).
            ' -P '.escapeshellarg((string) $config['port']).
            ' -u '.escapeshellarg($config['username']).
            ' '.escapeshellarg($config['database']).
            ' < '.escapeshellarg($fullPath),
            env: ['MYSQL_PWD' => $config['password']],
        );

        $process->setTimeout(300);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    public function delete(DatabaseBackup $backup): void
    {
        Storage::disk(self::DISK)->delete(self::DIRECTORY.'/'.$backup->filename);
        $backup->delete();
    }

    public function downloadPath(DatabaseBackup $backup): string
    {
        return Storage::disk(self::DISK)->path(self::DIRECTORY.'/'.$backup->filename);
    }
}
