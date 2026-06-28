<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Analytics']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Analytics']); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/analytics-charts.js'); ?>

    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Analytics Kependudukan','description' => 'Berdasarkan ' . number_format($totalCitizens, 0, ',', '.') . ' data penduduk terdaftar.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Analytics Kependudukan','description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Berdasarkan ' . number_format($totalCitizens, 0, ',', '.') . ' data penduduk terdaftar.')]); ?>
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

    <?php if($totalCitizens === 0): ?>
        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['icon' => 'bar-chart-3','title' => 'Belum ada data untuk dianalisis','description' => 'Grafik akan muncul setelah ada data Penduduk.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bar-chart-3','title' => 'Belum ada data untuk dianalisis','description' => 'Grafik akan muncul setelah ada data Penduduk.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
    <?php else: ?>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Jenis Kelamin</h2>
                <canvas id="chart-gender"></canvas>
            </div>
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Agama</h2>
                <canvas id="chart-religion"></canvas>
            </div>
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Kelompok Umur</h2>
                <canvas id="chart-age"></canvas>
            </div>
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 sm:col-span-2">
                <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Pendidikan</h2>
                <canvas id="chart-education"></canvas>
            </div>
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Pekerjaan</h2>
                <canvas id="chart-job"></canvas>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.renderChart('chart-gender', 'doughnut', <?php echo json_encode($genderChart['labels'], 15, 512) ?>, <?php echo json_encode($genderChart['data'], 15, 512) ?>);
                window.renderChart('chart-religion', 'pie', <?php echo json_encode($religionChart['labels'], 15, 512) ?>, <?php echo json_encode($religionChart['data'], 15, 512) ?>);
                window.renderChart('chart-age', 'bar', <?php echo json_encode($ageGroupChart['labels'], 15, 512) ?>, <?php echo json_encode($ageGroupChart['data'], 15, 512) ?>);
                window.renderChart('chart-education', 'bar', <?php echo json_encode($educationChart['labels'], 15, 512) ?>, <?php echo json_encode($educationChart['data'], 15, 512) ?>);
                window.renderChart('chart-job', 'pie', <?php echo json_encode($jobChart['labels'], 15, 512) ?>, <?php echo json_encode($jobChart['data'], 15, 512) ?>);
            });
        </script>
    <?php endif; ?>
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
<?php /**PATH D:\Portofolio\sik-ampel-laravel\resources\views/analytics/index.blade.php ENDPATH**/ ?>