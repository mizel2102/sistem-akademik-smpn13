<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name', 'label' => '', 'type' => 'text', 'value' => '', 'placeholder' => '', 'required' => false, 'error' => '']));

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

foreach (array_filter((['name', 'label' => '', 'type' => 'text', 'value' => '', 'placeholder' => '', 'required' => false, 'error' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="space-y-2">
    <?php if($label): ?>
        <label for="<?php echo e($name); ?>" class="block text-sm font-semibold text-slate-700">
            <?php echo e($label); ?>

            <?php if($required): ?>
                <span class="text-red-500">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <input
        type="<?php echo e($type); ?>"
        id="<?php echo e($name); ?>"
        name="<?php echo e($name); ?>"
        <?php if (! ($type === 'file')): ?> value="<?php echo e(old($name, $value)); ?>" <?php endif; ?>
        placeholder="<?php echo e($placeholder); ?>"
        <?php if($required): ?> required <?php endif; ?>
        <?php echo e($attributes->merge(['class' => 'w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-900 placeholder-slate-400 transition duration-300 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100 disabled:bg-slate-100 disabled:text-slate-500 disabled:cursor-not-allowed' . ($error ? ' border-red-400 focus:border-red-400 focus:ring-red-100' : '')])); ?>

    />

    <?php if($error): ?>
        <p class="text-xs font-medium text-red-600"><?php echo e($error); ?></p>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/components/input.blade.php ENDPATH**/ ?>