<?php
    $phases = [
        ['no' => 1, 'label' => 'Fondasi — Setup, Auth, RBAC', 'done' => true],
        ['no' => 2, 'label' => 'Master Data Wilayah & Referensi', 'done' => true],
        ['no' => 3, 'label' => 'Modul Penduduk, KK, Rumah', 'done' => true],
        ['no' => 4, 'label' => 'Verifikasi, Digital Signature, QR', 'done' => true],
        ['no' => 5, 'label' => 'Dashboard Analytics & GIS', 'done' => true],
        ['no' => 6, 'label' => 'Import, Export, Backup, Restore', 'done' => true],
        ['no' => 7, 'label' => 'Notifikasi, Email, WhatsApp', 'done' => true],
        ['no' => 8, 'label' => 'Audit Log, Monitoring, Laporan', 'done' => true],
        ['no' => 9, 'label' => 'Optimasi, Security Hardening, Deployment', 'done' => true],
    ];
?>

<div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] shadow-sm">
    <div class="flex flex-col gap-1 p-5 pb-3">
        <h3 class="font-display text-base font-semibold tracking-tight" style="font-family: var(--font-display);">Progres Pembangunan Sistem</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400">Dibangun bertahap sesuai roadmap Phase 1–9.</p>
    </div>
    <div class="space-y-2.5 p-5 pt-0">
        <?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-center gap-3 text-sm">
                <?php if($phase['done']): ?>
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'check-circle-2','class' => 'size-4 shrink-0 text-primary-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'check-circle-2','class' => 'size-4 shrink-0 text-primary-600']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'circle','class' => 'size-4 shrink-0 text-slate-300 dark:text-slate-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'circle','class' => 'size-4 shrink-0 text-slate-300 dark:text-slate-600']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                <?php endif; ?>
                <span class="<?php echo e($phase['done'] ? 'font-medium' : 'text-slate-500 dark:text-slate-400'); ?>">
                    Phase <?php echo e($phase['no']); ?>: <?php echo e($phase['label']); ?>

                </span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div><?php /**PATH D:\Portofolio\sik-ampel-laravel\resources\views/components/phase-roadmap.blade.php ENDPATH**/ ?>