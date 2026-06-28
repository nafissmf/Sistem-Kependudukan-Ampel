<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Monitoring Sistem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Monitoring Sistem']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Monitoring Sistem','description' => 'Status kesehatan aplikasi secara real-time.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Monitoring Sistem','description' => 'Status kesehatan aplikasi secara real-time.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">Database</p>
                <span class="size-2.5 rounded-full <?php echo e($database['status'] === 'OK' ? 'bg-primary-600' : 'bg-danger-500'); ?>"></span>
            </div>
            <p class="mt-1 font-display text-lg font-bold" style="font-family: var(--font-display);"><?php echo e($database['status']); ?></p>
            <p class="mt-0.5 text-xs text-slate-400"><?php echo e($database['driver'] ?? $database['message'] ?? ''); ?></p>
        </div>

        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">Queue</p>
                <span class="size-2.5 rounded-full <?php echo e($queue['status'] === 'OK' ? 'bg-primary-600' : 'bg-danger-500'); ?>"></span>
            </div>
            <p class="mt-1 font-display text-lg font-bold" style="font-family: var(--font-display);"><?php echo e($queue['pending'] ?? 0); ?> pending</p>
            <p class="mt-0.5 text-xs text-slate-400"><?php echo e($queue['failed'] ?? 0); ?> gagal</p>
        </div>

        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">Storage Publik</p>
                <span class="size-2.5 rounded-full <?php echo e($storage['status'] === 'OK' ? 'bg-primary-600' : 'bg-danger-500'); ?>"></span>
            </div>
            <p class="mt-1 font-display text-lg font-bold" style="font-family: var(--font-display);"><?php echo e(number_format(($storage['total_size'] ?? 0) / 1048576, 2)); ?> MB</p>
            <p class="mt-0.5 text-xs text-slate-400"><?php echo e($storage['file_count'] ?? 0); ?> file</p>
        </div>

        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <p class="text-sm text-slate-500">Backup Terakhir</p>
            <p class="mt-1 font-display text-lg font-bold" style="font-family: var(--font-display);"><?php echo e($lastBackup?->backup_date->diffForHumans() ?? 'Belum ada'); ?></p>
            <a href="<?php echo e(route('backup.index')); ?>" class="mt-0.5 text-xs text-primary-600 hover:underline">Kelola Backup →</a>
        </div>
    </div>

    <div class="mt-4 rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
        <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Informasi Aplikasi</h2>
        <dl class="grid grid-cols-2 gap-4 text-sm sm:grid-cols-4">
            <div><dt class="text-xs text-slate-400">PHP Version</dt><dd class="mt-0.5 font-mono" style="font-family: var(--font-mono);"><?php echo e($phpVersion); ?></dd></div>
            <div><dt class="text-xs text-slate-400">Laravel Version</dt><dd class="mt-0.5 font-mono" style="font-family: var(--font-mono);"><?php echo e($laravelVersion); ?></dd></div>
            <div><dt class="text-xs text-slate-400">Environment</dt><dd class="mt-0.5"><?php echo e(config('app.env')); ?></dd></div>
            <div><dt class="text-xs text-slate-400">Debug Mode</dt><dd class="mt-0.5"><?php echo e(config('app.debug') ? 'ON ⚠️' : 'OFF'); ?></dd></div>
        </dl>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH D:\Portofolio\sik-ampel-laravel\resources\views/monitoring/index.blade.php ENDPATH**/ ?>