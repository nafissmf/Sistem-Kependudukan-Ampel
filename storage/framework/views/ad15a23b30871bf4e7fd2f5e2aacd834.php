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
    <h1>Laporan Rumah</h1>
    <p class="subtitle">Sistem Informasi Kependudukan Kecamatan Ampel — dicetak <?php echo e(now()->translatedFormat('d F Y H:i')); ?></p>
    <table>
        <thead><tr><th>Nomor Rumah</th><th>Alamat</th><th>Desa</th><th>Koordinat</th><th>Status</th></tr></thead>
        <tbody>
            <?php $__currentLoopData = $houses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($house->house_number ?? '-'); ?></td>
                    <td><?php echo e($house->address ?? '-'); ?></td>
                    <td><?php echo e($house->village?->name ?? '-'); ?></td>
                    <td><?php echo e($house->latitude ?? '-'); ?>, <?php echo e($house->longitude ?? '-'); ?></td>
                    <td><?php echo e($house->verification_status->label()); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH D:\Portofolio\sik-ampel-laravel\resources\views/reports/houses-pdf.blade.php ENDPATH**/ ?>