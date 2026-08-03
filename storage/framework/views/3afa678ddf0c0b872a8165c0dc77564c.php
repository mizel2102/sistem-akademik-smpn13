<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => null, 'subtitle' => null, 'badge' => null]));

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

foreach (array_filter((['title' => null, 'subtitle' => null, 'badge' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge(['class' => 'rounded-[32px] border border-slate-200/80 bg-white/85 p-6 shadow-[0_28px_70px_-35px_rgba(15,23,42,0.28)] backdrop-blur-xl sm:p-8'])); ?>>
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="min-w-0">
            <?php if($title): ?>
                <h1 class="text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl"><?php echo e($title); ?></h1>
            <?php endif; ?>
            <?php if($subtitle): ?>
                <p class="mt-2 text-sm leading-6 text-slate-600"><?php echo e($subtitle); ?></p>
            <?php endif; ?>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <?php if($badge): ?>
                <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700"><?php echo e($badge); ?></span>
            <?php endif; ?>
            <?php if(isset($actions)): ?>
                <?php echo e($actions); ?>

            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/components/page-header.blade.php ENDPATH**/ ?>