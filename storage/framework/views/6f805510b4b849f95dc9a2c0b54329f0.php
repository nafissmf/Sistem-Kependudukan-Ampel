<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title ?? 'Dashboard'); ?> — SIK Ampel</title>
    <meta name="theme-color" content="#2e7d32">

    <script>
        (function () {
            var saved = localStorage.getItem('sik-ampel-theme');
            var dark = saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (dark) document.documentElement.classList.add('dark');
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="antialiased" style="font-family: var(--font-sans);" x-data>
    <div class="min-h-screen bg-[var(--bg)]">
        <?php if (isset($component)) { $__componentOriginal2880b66d47486b4bfeaf519598a469d6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2880b66d47486b4bfeaf519598a469d6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar','data' => ['role' => auth()->user()->role->code]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(auth()->user()->role->code)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2880b66d47486b4bfeaf519598a469d6)): ?>
<?php $attributes = $__attributesOriginal2880b66d47486b4bfeaf519598a469d6; ?>
<?php unset($__attributesOriginal2880b66d47486b4bfeaf519598a469d6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2880b66d47486b4bfeaf519598a469d6)): ?>
<?php $component = $__componentOriginal2880b66d47486b4bfeaf519598a469d6; ?>
<?php unset($__componentOriginal2880b66d47486b4bfeaf519598a469d6); ?>
<?php endif; ?>

        <div class="transition-all duration-200" :class="$store.ui.collapsed ? 'lg:pl-20' : 'lg:pl-64'">
            <?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => ['user' => auth()->user()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(auth()->user())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $attributes = $__attributesOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__attributesOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $component = $__componentOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__componentOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
            <main class="p-4 pb-24 sm:p-6 lg:pb-6">
                <?php echo e($slot); ?>

            </main>
        </div>

        <?php if (isset($component)) { $__componentOriginal91530f48093dbfe9d7d6cfefc4ce84c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91530f48093dbfe9d7d6cfefc4ce84c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.bottom-nav','data' => ['role' => auth()->user()->role->code]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('bottom-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(auth()->user()->role->code)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91530f48093dbfe9d7d6cfefc4ce84c1)): ?>
<?php $attributes = $__attributesOriginal91530f48093dbfe9d7d6cfefc4ce84c1; ?>
<?php unset($__attributesOriginal91530f48093dbfe9d7d6cfefc4ce84c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91530f48093dbfe9d7d6cfefc4ce84c1)): ?>
<?php $component = $__componentOriginal91530f48093dbfe9d7d6cfefc4ce84c1; ?>
<?php unset($__componentOriginal91530f48093dbfe9d7d6cfefc4ce84c1); ?>
<?php endif; ?>

        
        <div
            x-show="$store.toast.visible" x-cloak x-transition
            class="glass-panel fixed bottom-20 right-4 z-[60] max-w-sm rounded-xl p-4 shadow-lg lg:bottom-4"
        >
            <p class="text-sm font-semibold" x-text="$store.toast.title"></p>
            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400" x-text="$store.toast.description"></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\Portofolio\sik-ampel-laravel\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>