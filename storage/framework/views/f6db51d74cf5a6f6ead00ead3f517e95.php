<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1e293b; }
        h1 { font-size: 16px; margin-bottom: 2px; }
        p.subtitle { color: #64748b; margin-top: 0; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; }
        th { background: #f1f5f9; }
    </style>
</head>
<body>
    <h1>Laporan Kartu Keluarga</h1>
    <p class="subtitle">Sistem Informasi Kependudukan Kecamatan Ampel — dicetak <?php echo e(now()->translatedFormat('d F Y H:i')); ?></p>
    <table>
        <thead><tr><th>Nomor KK</th><th>Kepala Keluarga</th><th>Desa</th><th>Anggota</th><th>Status</th></tr></thead>
        <tbody>
            <?php $__currentLoopData = $familyCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $familyCard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($familyCard->number); ?></td>
                    <td><?php echo e($familyCard->headCitizen?->fullname ?? '-'); ?></td>
                    <td><?php echo e($familyCard->village?->name ?? '-'); ?></td>
                    <td><?php echo e($familyCard->members_count); ?></td>
                    <td><?php echo e($familyCard->verification_status->label()); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH D:\Portofolio\sik-ampel-laravel\resources\views/reports/family-cards-pdf.blade.php ENDPATH**/ ?>