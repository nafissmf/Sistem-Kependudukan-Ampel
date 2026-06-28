<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label', 'icon', 'value' => null, 'accent' => 'primary', 'hint' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['label', 'icon', 'value' => null, 'accent' => 'primary', 'hint' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $accentClass = match ($accent) {
        'secondary' => 'bg-secondary-50 text-secondary-600 dark:bg-secondary-600/15 dark:text-secondary-400',
        'warning' => 'bg-amber-50 text-warning-500 dark:bg-warning-500/15',
        'danger' => 'bg-red-50 text-danger-500 dark:bg-danger-500/15',
        default => 'bg-primary-50 text-primary-600 dark:bg-primary-600/15 dark:text-primary-300',
    };
?>

<div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] shadow-sm">
    <div class="flex items-start justify-between gap-4 p-5">
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400"><?php echo e($label); ?></p>
            <?php if($value === null): ?>
                <p class="mt-1 font-display text-2xl font-bold text-slate-300 dark:text-slate-600" style="font-family: var(--font-display);">—</p>
            <?php else: ?>
                <p class="mt-1 font-display text-2xl font-bold tabular-nums" style="font-family: var(--font-display);"><?php echo e(number_format($value, 0, ',', '.')); ?></p>
            <?php endif; ?>
            <?php if($hint): ?>
                <p class="mt-1 text-xs text-slate-400"><?php echo e($hint); ?></p>
            <?php endif; ?>
        </div>
        <div class="flex size-11 shrink-0 items-center justify-center rounded-xl <?php echo e($accentClass); ?>">
            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $icon,'class' => 'size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => 'size-5']); ?>
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
        </div>
    </div>
</div>
<?php /**PATH D:\Portofolio\sik-ampel-laravel\resources\views/components/stat-widget.blade.php ENDPATH**/ ?>