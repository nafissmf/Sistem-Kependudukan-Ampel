<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name', 'type' => 'text']));

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

foreach (array_filter((['name', 'type' => 'text']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<input
    id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" type="<?php echo e($type); ?>"
    value="<?php echo e(old($name, $value ?? '')); ?>"
    <?php echo e($attributes->merge(['class' => 'flex h-10 w-full rounded-xl border border-[var(--border)] bg-[var(--card-bg)] px-3.5 py-2 text-sm shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 ' . ($errors->has($name) ? 'border-danger-500' : '')])); ?>

>
<?php /**PATH D:\Portofolio\sik-ampel-laravel\resources\views/components/text-input.blade.php ENDPATH**/ ?>