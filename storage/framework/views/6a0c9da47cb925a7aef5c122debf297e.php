<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Detail KK']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Detail KK']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'KK ' . $familyCard->number,'description' => 'Kepala Keluarga: ' . ($familyCard->headCitizen?->fullname ?? '—')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('KK ' . $familyCard->number),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Kepala Keluarga: ' . ($familyCard->headCitizen?->fullname ?? '—'))]); ?>
         <?php $__env->slot('actions', null, []); ?> 
            <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $familyCard->verification_status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($familyCard->verification_status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kk.update')): ?>
                <a href="<?php echo e(route('family-cards.edit', $familyCard)); ?>" class="flex h-10 items-center gap-2 rounded-xl border border-[var(--border)] px-4 text-sm font-medium hover:bg-slate-50 dark:hover:bg-white/5">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'settings','class' => 'size-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'settings','class' => 'size-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Edit
                </a>
            <?php endif; ?>
         <?php $__env->endSlot(); ?>
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

    <?php if(session('success')): ?>
        <div class="mb-4 rounded-xl bg-primary-50 px-4 py-3 text-sm text-primary-700 dark:bg-primary-600/15 dark:text-primary-300"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="space-y-4 lg:col-span-2">
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Informasi KK</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div><dt class="text-xs text-slate-400">Nomor KK</dt><dd class="mt-0.5 font-mono text-sm" style="font-family: var(--font-mono);"><?php echo e($familyCard->number); ?></dd></div>
                    <div><dt class="text-xs text-slate-400">Tanggal Terbit</dt><dd class="mt-0.5 text-sm"><?php echo e($familyCard->issued_date?->translatedFormat('d F Y') ?? '—'); ?></dd></div>
                    <div><dt class="text-xs text-slate-400">Desa</dt><dd class="mt-0.5 text-sm"><?php echo e($familyCard->village?->name ?? '—'); ?></dd></div>
                    <div><dt class="text-xs text-slate-400">Rumah</dt><dd class="mt-0.5 text-sm"><?php echo e($familyCard->house?->house_number ?? '— Belum ditentukan —'); ?></dd></div>
                    <div class="sm:col-span-2"><dt class="text-xs text-slate-400">Alamat</dt><dd class="mt-0.5 text-sm"><?php echo e($familyCard->address ?? '—'); ?></dd></div>
                </dl>
            </div>

            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Anggota Keluarga (<?php echo e($familyCard->members->count()); ?>)</h2>
                <?php if($familyCard->members->isEmpty()): ?>
                    <p class="mt-2 text-sm text-slate-400">Belum ada anggota terdaftar.</p>
                <?php else: ?>
                    <ul class="mt-3 divide-y divide-[var(--border)]">
                        <?php $__currentLoopData = $familyCard->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-center justify-between py-2.5 text-sm">
                                <div>
                                    <a href="<?php echo e(route('citizens.show', $member)); ?>" class="font-medium text-primary-600 hover:underline"><?php echo e($member->fullname); ?></a>
                                    <span class="ml-2 font-mono text-xs text-slate-400" style="font-family: var(--font-mono);"><?php echo e($member->nik); ?></span>
                                </div>
                                <span class="text-xs text-slate-400"><?php echo e($member->pivot->relationship_id ? \App\Models\FamilyRelationship::find($member->pivot->relationship_id)?->name : '—'); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Riwayat</h2>
                <dl class="mt-3 space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-slate-400">Dibuat</dt><dd><?php echo e($familyCard->created_at->translatedFormat('d M Y H:i')); ?></dd></div>
                    <div class="flex justify-between"><dt class="text-slate-400">Diperbarui</dt><dd><?php echo e($familyCard->updated_at->translatedFormat('d M Y H:i')); ?></dd></div>
                </dl>
            </div>

            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 text-center">
                <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">QR Code Verifikasi</h2>
                <?php if($familyCard->qr_code): ?>
                    <img src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($familyCard->qr_code)); ?>" alt="QR KK" class="mx-auto size-40">
                    <p class="mt-2 text-xs text-slate-400">Scan untuk membuka halaman verifikasi publik.</p>
                <?php else: ?>
                    <p class="text-sm text-slate-400">Belum ada QR Code.</p>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('qr.create')): ?>
                    <form method="POST" action="<?php echo e(route('family-cards.qr-code', $familyCard)); ?>" class="mt-3">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="flex h-9 w-full items-center justify-center gap-2 rounded-xl bg-secondary-600 px-4 text-sm font-medium text-white hover:bg-secondary-700">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'qr-code','class' => 'size-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'qr-code','class' => 'size-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> <?php echo e($familyCard->qr_code ? 'Buat Ulang QR' : 'Generate QR'); ?>

                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
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
<?php /**PATH D:\Portofolio\sik-ampel-laravel\resources\views/family-cards/show.blade.php ENDPATH**/ ?>