<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name', 'options' => [], 'placeholder' => '— Pilih —', 'optionValue' => 'id', 'optionLabel' => 'name']));

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

foreach (array_filter((['name', 'options' => [], 'placeholder' => '— Pilih —', 'optionValue' => 'id', 'optionLabel' => 'name']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php $selected = old($name, $value ?? ''); ?>

<select
    id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
    <?php echo e($attributes->merge(['class' => 'flex h-10 w-full rounded-xl border border-[var(--border)] bg-[var(--card-bg)] px-3.5 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 ' . ($errors->has($name) ? 'border-danger-500' : '')])); ?>

>
    <option value=""><?php echo e($placeholder); ?></option>
    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $value_ = is_array($option) ? $option[$optionValue] : $option->{$optionValue}; ?>
        <?php $label_ = is_array($option) ? $option[$optionLabel] : $option->{$optionLabel}; ?>
        <option value="<?php echo e($value_); ?>" <?php if((string) $selected === (string) $value_): echo 'selected'; endif; ?>><?php echo e($label_); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<?php /**PATH D:\Portofolio\sik-ampel-laravel\resources\views/components/select-input.blade.php ENDPATH**/ ?>