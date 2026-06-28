<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['role']));

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

foreach (array_filter((['role']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $menu = collect(\App\Support\Rbac::sidebarMenu())
        ->filter(fn ($item) => \App\Support\Rbac::canAccessModule($role, $item['module']))
        ->values();
?>

<div x-show="$store.ui.mobileOpen" x-cloak @click="$store.ui.closeMobile()" class="fixed inset-0 z-40 bg-black/40 lg:hidden"></div>

<aside
    class="fixed inset-y-0 left-0 z-50 flex flex-col border-r border-[var(--border)] bg-[var(--card-bg)] transition-all duration-200"
    :class="$store.ui.collapsed ? 'w-20' : 'w-64'"
    x-bind:class="($store.ui.mobileOpen ? 'translate-x-0' : '-translate-x-full') + ' lg:translate-x-0'"
>
    <div class="flex h-16 items-center justify-between gap-2 border-b border-[var(--border)] px-4">
        <div class="flex items-center gap-2 overflow-hidden">
            <img src="<?php echo e(asset('images/logo-boyolali.png')); ?>"
                 alt="Logo Kabupaten Boyolali"
                 class="size-9 shrink-0 object-contain" />
            <span x-show="!$store.ui.collapsed" class="truncate font-display text-sm font-bold leading-tight" style="font-family: var(--font-display);">SIK Ampel</span>
        </div>
        <button class="text-slate-400 hover:text-slate-600 lg:hidden" @click="$store.ui.closeMobile()" aria-label="Tutup menu">
            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'x','class' => 'size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'x','class' => 'size-5']); ?>
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
        </button>
    </div>

    <nav class="thin-scrollbar flex-1 space-y-1 overflow-y-auto p-3">
        <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $active = request()->is(trim($item['href'], '/').'*'); ?>
            <a
                href="<?php echo e($item['href']); ?>"
                @click="$store.ui.closeMobile()"
                title="<?php echo e($item['label']); ?>"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors <?php echo e($active ? 'bg-primary-50 text-primary-700 dark:bg-primary-600/15 dark:text-primary-300' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-white/5'); ?>"
                :class="$store.ui.collapsed && 'justify-center'"
            >
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $item['icon'],'class' => 'size-[1.15rem] shrink-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['icon']),'class' => 'size-[1.15rem] shrink-0']); ?>
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
                <span x-show="!$store.ui.collapsed" class="truncate"><?php echo e($item['label']); ?></span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>
</aside>
<?php /**PATH D:\Portofolio\sik-ampel-laravel\resources\views/components/sidebar.blade.php ENDPATH**/ ?>