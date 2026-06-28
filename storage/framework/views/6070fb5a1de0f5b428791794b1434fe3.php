<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status']));

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

foreach (array_filter((['status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $status = $status instanceof \App\Enums\VerificationStatus ? $status : \App\Enums\VerificationStatus::from($status);
?>

<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium <?php echo e($status->badgeClass()); ?>">
    <?php echo e($status->label()); ?>

</span>
<?php /**PATH D:\Portofolio\sik-ampel-laravel\resources\views/components/status-badge.blade.php ENDPATH**/ ?>