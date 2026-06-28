<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dashboard']); ?>
<?php
    $laki      = $genderData->get('L', 0);
    $perempuan = $genderData->get('P', 0);
    $totalG    = $laki + $perempuan;
    $pctL      = $totalG ? round($laki / $totalG * 100) : 0;
    $pctP      = $totalG ? 100 - $pctL : 0;

    $verifTotal    = $verifBreakdown->sum();
    $verifVerified = $verifBreakdown->get('verified', 0);
    $verifPending  = $verifBreakdown->get('pending', 0);
    $verifRejected = $verifBreakdown->get('rejected', 0);
    $verifRevision = $verifBreakdown->get('revision', 0);

    $pctVerified = $verifTotal ? round($verifVerified / $verifTotal * 100) : 0;
    $pctPending  = $verifTotal ? round($verifPending  / $verifTotal * 100) : 0;
    $pctRejected = $verifTotal ? round($verifRejected / $verifTotal * 100) : 0;
    $pctRevision = $verifTotal ? 100 - $pctVerified - $pctPending - $pctRejected : 0;

    $role = auth()->user()->role->code;
?>

<div class="space-y-5">

    
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary-800 via-primary-700 to-primary-600 shadow-lg">
        
        <div class="pointer-events-none absolute -right-16 -top-16 size-64 rounded-full bg-white/5"></div>
        <div class="pointer-events-none absolute -bottom-12 right-40 size-48 rounded-full bg-white/5"></div>

        <div class="relative flex flex-col gap-6 p-6 sm:flex-row sm:items-center sm:justify-between">
            
            <div class="flex items-center gap-4">
                <img src="<?php echo e(asset('images/logo-boyolali.png')); ?>"
                     alt="Logo Boyolali"
                     class="size-16 shrink-0 object-contain drop-shadow" />
                <div>
                    <p class="text-xs font-medium uppercase tracking-widest text-white/60"><?php echo e($today); ?></p>
                    <h1 class="mt-0.5 font-display text-xl font-bold text-white sm:text-2xl" style="font-family:var(--font-display)">
                        <?php echo e($greeting); ?>, <?php echo e(auth()->user()->fullname); ?>

                    </h1>
                    <div class="mt-2 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-0.5 text-xs font-semibold text-white backdrop-blur-sm">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'shield-check','class' => 'size-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'shield-check','class' => 'size-3']); ?>
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
                            <?php echo e(auth()->user()->role->name); ?>

                        </span>
                        <span class="rounded-full bg-accent-400/25 px-3 py-0.5 text-xs font-semibold text-accent-300">
                            Sistem Aktif
                        </span>
                    </div>
                    <p class="mt-1.5 text-xs text-white/50">Kecamatan Ampel · Kabupaten Boyolali</p>
                </div>
            </div>

            
            <div class="grid grid-cols-2 gap-2 sm:gap-3">
                <?php if($totalCitizens !== null): ?>
                <div class="rounded-xl bg-white/10 px-4 py-3 text-center backdrop-blur-sm">
                    <p class="font-display text-2xl font-bold text-white tabular-nums" style="font-family:var(--font-display)"><?php echo e(number_format($totalCitizens,0,',','.')); ?></p>
                    <p class="mt-0.5 text-xs text-white/60">Penduduk</p>
                </div>
                <?php endif; ?>
                <?php if($totalFamilyCards !== null): ?>
                <div class="rounded-xl bg-white/10 px-4 py-3 text-center backdrop-blur-sm">
                    <p class="font-display text-2xl font-bold text-white tabular-nums" style="font-family:var(--font-display)"><?php echo e(number_format($totalFamilyCards,0,',','.')); ?></p>
                    <p class="mt-0.5 text-xs text-white/60">Kartu Keluarga</p>
                </div>
                <?php endif; ?>
                <?php if($totalHouses !== null): ?>
                <div class="rounded-xl bg-white/10 px-4 py-3 text-center backdrop-blur-sm">
                    <p class="font-display text-2xl font-bold text-white tabular-nums" style="font-family:var(--font-display)"><?php echo e(number_format($totalHouses,0,',','.')); ?></p>
                    <p class="mt-0.5 text-xs text-white/60">Rumah</p>
                </div>
                <?php endif; ?>
                <?php if($pendingVerif !== null): ?>
                <div class="rounded-xl px-4 py-3 text-center ring-1 ring-amber-300/30" style="background:rgba(251,140,0,.18)">
                    <p class="font-display text-2xl font-bold tabular-nums text-amber-200" style="font-family:var(--font-display)"><?php echo e(number_format($pendingVerif,0,',','.')); ?></p>
                    <p class="mt-0.5 text-xs text-amber-200/70">Perlu Verifikasi</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <section>
        <p class="mb-2.5 text-xs font-semibold uppercase tracking-wider text-slate-400">Aksi Cepat</p>
        <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">

            <?php if(\App\Support\Rbac::has($role,'penduduk','create')): ?>
            <a href="<?php echo e(route('citizens.create')); ?>"
               class="group flex flex-col items-center gap-2 rounded-xl border border-[var(--border)] bg-[var(--card-bg)] py-4 text-center shadow-sm transition-all hover:-translate-y-0.5 hover:border-primary-300 hover:shadow-md">
                <span class="flex size-10 items-center justify-center rounded-xl bg-primary-600 text-white shadow-sm">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'user-plus','class' => 'size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'user-plus','class' => 'size-5']); ?>
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
                </span>
                <span class="text-xs font-semibold leading-tight text-slate-600 dark:text-slate-300">Tambah<br>Penduduk</span>
            </a>
            <?php endif; ?>

            <?php if(\App\Support\Rbac::has($role,'kk','create')): ?>
            <a href="<?php echo e(route('family-cards.create')); ?>"
               class="group flex flex-col items-center gap-2 rounded-xl border border-[var(--border)] bg-[var(--card-bg)] py-4 text-center shadow-sm transition-all hover:-translate-y-0.5 hover:border-secondary-300 hover:shadow-md">
                <span class="flex size-10 items-center justify-center rounded-xl bg-secondary-600 text-white shadow-sm">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'id-card','class' => 'size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'id-card','class' => 'size-5']); ?>
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
                </span>
                <span class="text-xs font-semibold leading-tight text-slate-600 dark:text-slate-300">Tambah<br>KK</span>
            </a>
            <?php endif; ?>

            <?php if(\App\Support\Rbac::has($role,'rumah','create')): ?>
            <a href="<?php echo e(route('houses.create')); ?>"
               class="group flex flex-col items-center gap-2 rounded-xl border border-[var(--border)] bg-[var(--card-bg)] py-4 text-center shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md" style="--tw-hover-border-color:#0d9488">
                <span class="flex size-10 items-center justify-center rounded-xl text-white shadow-sm" style="background:#0f766e">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'home','class' => 'size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'home','class' => 'size-5']); ?>
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
                </span>
                <span class="text-xs font-semibold leading-tight text-slate-600 dark:text-slate-300">Tambah<br>Rumah</span>
            </a>
            <?php endif; ?>

            <?php if(\App\Support\Rbac::has($role,'scan','read')): ?>
            <a href="<?php echo e(route('scanner.index')); ?>"
               class="group flex flex-col items-center gap-2 rounded-xl border border-[var(--border)] bg-[var(--card-bg)] py-4 text-center shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md">
                <span class="flex size-10 items-center justify-center rounded-xl text-white shadow-sm" style="background:#7c3aed">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'scan-line','class' => 'size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'scan-line','class' => 'size-5']); ?>
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
                </span>
                <span class="text-xs font-semibold leading-tight text-slate-600 dark:text-slate-300">Scan<br>QR</span>
            </a>
            <?php endif; ?>

            <?php if(\App\Support\Rbac::has($role,'gis','read')): ?>
            <a href="<?php echo e(route('gis.index')); ?>"
               class="group flex flex-col items-center gap-2 rounded-xl border border-[var(--border)] bg-[var(--card-bg)] py-4 text-center shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md">
                <span class="flex size-10 items-center justify-center rounded-xl text-white shadow-sm" style="background:#0284c7">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'map','class' => 'size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'map','class' => 'size-5']); ?>
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
                </span>
                <span class="text-xs font-semibold leading-tight text-slate-600 dark:text-slate-300">Peta<br>GIS</span>
            </a>
            <?php endif; ?>

            <?php if(\App\Support\Rbac::has($role,'laporan','export')): ?>
            <a href="<?php echo e(route('reports.index')); ?>"
               class="group flex flex-col items-center gap-2 rounded-xl border border-[var(--border)] bg-[var(--card-bg)] py-4 text-center shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md">
                <span class="flex size-10 items-center justify-center rounded-xl text-white shadow-sm" style="background:#ea580c">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'file-text','class' => 'size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'file-text','class' => 'size-5']); ?>
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
                </span>
                <span class="text-xs font-semibold leading-tight text-slate-600 dark:text-slate-300">Laporan<br>Export</span>
            </a>
            <?php endif; ?>

        </div>
    </section>

    
    <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        
        <div class="rounded-xl border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex size-11 items-center justify-center rounded-xl bg-primary-50 dark:bg-primary-900/30">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'users','class' => 'size-5 text-primary-600 dark:text-primary-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'users','class' => 'size-5 text-primary-600 dark:text-primary-400']); ?>
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
                <span class="text-xs font-medium text-primary-600 dark:text-primary-400">↑ Data</span>
            </div>
            <p class="mt-4 font-display text-3xl font-bold tabular-nums" style="font-family:var(--font-display)">
                <?php echo e($totalCitizens !== null ? number_format($totalCitizens,0,',','.') : '—'); ?>

            </p>
            <p class="mt-1 text-sm text-slate-500">Total Penduduk</p>
            <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-white/10">
                <div class="h-full rounded-full bg-primary-500" style="width:<?php echo e($totalCitizens ? min(100, $totalCitizens/100) : 0); ?>%"></div>
            </div>
        </div>

        
        <div class="rounded-xl border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex size-11 items-center justify-center rounded-xl bg-secondary-50 dark:bg-secondary-900/20">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'id-card','class' => 'size-5 text-secondary-600 dark:text-secondary-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'id-card','class' => 'size-5 text-secondary-600 dark:text-secondary-400']); ?>
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
                <span class="text-xs font-medium text-secondary-600 dark:text-secondary-400">↑ Data</span>
            </div>
            <p class="mt-4 font-display text-3xl font-bold tabular-nums" style="font-family:var(--font-display)">
                <?php echo e($totalFamilyCards !== null ? number_format($totalFamilyCards,0,',','.') : '—'); ?>

            </p>
            <p class="mt-1 text-sm text-slate-500">Kartu Keluarga</p>
            <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-white/10">
                <div class="h-full rounded-full bg-secondary-500" style="width:<?php echo e($totalFamilyCards ? min(100, $totalFamilyCards/10) : 0); ?>%"></div>
            </div>
        </div>

        
        <div class="rounded-xl border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex size-11 items-center justify-center rounded-xl" style="background:#f0fdf4">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'home','class' => 'size-5','style' => 'color:#0f766e']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'home','class' => 'size-5','style' => 'color:#0f766e']); ?>
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
                <span class="text-xs font-medium" style="color:#0f766e">↑ Data</span>
            </div>
            <p class="mt-4 font-display text-3xl font-bold tabular-nums" style="font-family:var(--font-display)">
                <?php echo e($totalHouses !== null ? number_format($totalHouses,0,',','.') : '—'); ?>

            </p>
            <p class="mt-1 text-sm text-slate-500">Total Rumah</p>
            <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-white/10">
                <div class="h-full rounded-full" style="background:#0f766e; width:<?php echo e($totalHouses ? min(100, $totalHouses/5) : 0); ?>%"></div>
            </div>
        </div>

        
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 shadow-sm dark:border-amber-900/30 dark:bg-amber-900/10">
            <div class="flex items-center justify-between">
                <div class="flex size-11 items-center justify-center rounded-xl bg-amber-100 dark:bg-amber-900/30">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'clock','class' => 'size-5 text-amber-600 dark:text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'clock','class' => 'size-5 text-amber-600 dark:text-amber-400']); ?>
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
                <span class="text-xs font-medium text-amber-600 dark:text-amber-400">Perlu Aksi</span>
            </div>
            <p class="mt-4 font-display text-3xl font-bold tabular-nums text-amber-700 dark:text-amber-300" style="font-family:var(--font-display)">
                <?php echo e($pendingVerif !== null ? number_format($pendingVerif,0,',','.') : '—'); ?>

            </p>
            <p class="mt-1 text-sm text-amber-600 dark:text-amber-400">Menunggu Verifikasi</p>
            <a href="<?php echo e(route('verification.index')); ?>" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-amber-600 hover:underline dark:text-amber-400">
                Lihat semua <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'size-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'size-3']); ?>
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
            </a>
        </div>

    </section>

    
    <section class="grid gap-4 lg:grid-cols-3">

        
        <div class="rounded-xl border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <h3 class="mb-4 font-display text-sm font-semibold text-slate-700 dark:text-slate-200" style="font-family:var(--font-display)">
                Status Verifikasi Penduduk
            </h3>
            <?php if($verifTotal > 0): ?>
                
                <div class="mb-4 flex h-4 w-full overflow-hidden rounded-full">
                    <?php if($pctVerified > 0): ?><div class="h-full" style="width:<?php echo e($pctVerified); ?>%;background:#2e7d32" title="Terverifikasi"></div><?php endif; ?>
                    <?php if($pctPending  > 0): ?><div class="h-full" style="width:<?php echo e($pctPending); ?>%;background:#fb8c00" title="Menunggu"></div><?php endif; ?>
                    <?php if($pctRejected > 0): ?><div class="h-full" style="width:<?php echo e($pctRejected); ?>%;background:#e53935" title="Ditolak"></div><?php endif; ?>
                    <?php if($pctRevision > 0): ?><div class="h-full" style="width:<?php echo e($pctRevision); ?>%;background:#1565c0" title="Revisi"></div><?php endif; ?>
                </div>

                <ul class="space-y-2.5">
                    <?php $__currentLoopData = [
                        ['Terverifikasi', $verifVerified, $pctVerified, '#2e7d32'],
                        ['Menunggu',      $verifPending,  $pctPending,  '#fb8c00'],
                        ['Ditolak',       $verifRejected, $pctRejected, '#e53935'],
                        ['Revisi',        $verifRevision, $pctRevision, '#1565c0'],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$lbl, $val, $pct, $clr]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($val > 0): ?>
                        <li class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2.5">
                                <span class="size-2.5 shrink-0 rounded-full" style="background:<?php echo e($clr); ?>"></span>
                                <span class="text-slate-600 dark:text-slate-300"><?php echo e($lbl); ?></span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-semibold tabular-nums"><?php echo e(number_format($val,0,',','.')); ?></span>
                                <span class="w-8 text-right text-xs text-slate-400"><?php echo e($pct); ?>%</span>
                            </div>
                        </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <p class="py-6 text-center text-sm text-slate-400">Belum ada data verifikasi.</p>
            <?php endif; ?>
        </div>

        
        <div class="rounded-xl border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <h3 class="mb-4 font-display text-sm font-semibold text-slate-700 dark:text-slate-200" style="font-family:var(--font-display)">
                Distribusi Gender
            </h3>
            <?php if($totalG > 0): ?>
                
                <div class="mb-4 flex h-4 overflow-hidden rounded-full">
                    <div class="h-full bg-primary-500 transition-all" style="width:<?php echo e($pctL); ?>%"></div>
                    <div class="h-full" style="width:<?php echo e($pctP); ?>%; background:#ec4899"></div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-primary-50 p-4 text-center dark:bg-primary-900/20">
                        <p class="font-display text-2xl font-bold text-primary-700 tabular-nums dark:text-primary-300" style="font-family:var(--font-display)">
                            <?php echo e(number_format($laki,0,',','.')); ?>

                        </p>
                        <p class="mt-1 text-xs font-medium text-primary-600 dark:text-primary-400">Laki-laki</p>
                        <p class="text-xs text-primary-400"><?php echo e($pctL); ?>%</p>
                    </div>
                    <div class="rounded-xl p-4 text-center" style="background:#fdf2f8">
                        <p class="font-display text-2xl font-bold tabular-nums" style="font-family:var(--font-display);color:#be185d">
                            <?php echo e(number_format($perempuan,0,',','.')); ?>

                        </p>
                        <p class="mt-1 text-xs font-medium" style="color:#db2777">Perempuan</p>
                        <p class="text-xs" style="color:#f9a8d4"><?php echo e($pctP); ?>%</p>
                    </div>
                </div>

                <div class="mt-3 flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 dark:bg-white/5">
                    <span class="text-xs text-slate-500">Total Penduduk</span>
                    <span class="font-display text-sm font-bold tabular-nums" style="font-family:var(--font-display)"><?php echo e(number_format($totalG,0,',','.')); ?></span>
                </div>
            <?php else: ?>
                <p class="py-6 text-center text-sm text-slate-400">Belum ada data gender.</p>
            <?php endif; ?>
        </div>

        
        <div class="rounded-xl border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-display text-sm font-semibold text-slate-700 dark:text-slate-200" style="font-family:var(--font-display)">
                    Aktivitas Terbaru
                </h3>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('audit.read')): ?>
                    <a href="<?php echo e(route('audit.index')); ?>" class="text-xs font-medium text-primary-600 hover:underline dark:text-primary-400">
                        Semua log
                    </a>
                <?php endif; ?>
            </div>

            <?php if($recentActivity->isEmpty()): ?>
                <p class="py-6 text-center text-sm text-slate-400">Belum ada aktivitas.</p>
            <?php else: ?>
                <ul class="space-y-3">
                    <?php
                        $dotColor = [
                            'create'  => '#2e7d32',
                            'update'  => '#1565c0',
                            'delete'  => '#e53935',
                            'approve' => '#0f766e',
                            'reject'  => '#fb8c00',
                            'backup'  => '#7c3aed',
                            'restore' => '#ea580c',
                        ];
                    ?>
                    <?php $__currentLoopData = $recentActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex items-start gap-3">
                        <span class="mt-1.5 size-2 shrink-0 rounded-full"
                              style="background:<?php echo e($dotColor[$log->action->value] ?? '#94a3b8'); ?>"></span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-slate-700 dark:text-slate-200">
                                <?php echo e($log->user?->fullname ?? 'Sistem'); ?>

                                <span class="font-normal text-slate-400">·</span>
                                <span class="capitalize text-slate-500"><?php echo e($log->module); ?></span>
                            </p>
                            <p class="text-xs text-slate-400"><?php echo e($log->created_at->diffForHumans()); ?></p>
                        </div>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>

    </section>

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
<?php /**PATH D:\Portofolio\sik-ampel-laravel\resources\views/dashboard/index.blade.php ENDPATH**/ ?>