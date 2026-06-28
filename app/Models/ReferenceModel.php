<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Base class untuk semua tabel "MASTER REFERENCE" (agama, pendidikan,
 * pekerjaan, dst). Strukturnya identik (id, code, name, sort_order),
 * jadi diabstraksikan di sini supaya tidak menulis ulang hal yang sama
 * 11 kali. Lihat database/migrations/..._create_reference_tables.php.
 */
abstract class ReferenceModel extends Model
{
    use HasUuids;

    protected $fillable = ['code', 'name', 'sort_order'];

    protected static function booted(): void
    {
        static::addGlobalScope(function ($query) {
            $query->orderBy('sort_order')->orderBy('name');
        });
    }
}
