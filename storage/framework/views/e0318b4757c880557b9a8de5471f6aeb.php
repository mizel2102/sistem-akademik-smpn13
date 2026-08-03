<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'action',
    'submitLabel',
    'method' => 'POST',
    'teacher' => null,
]));

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

foreach (array_filter(([
    'action',
    'submitLabel',
    'method' => 'POST',
    'teacher' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<form action="<?php echo e($action); ?>" method="POST" class="mt-8 space-y-6">
    <?php echo csrf_field(); ?>
    <?php if($method !== 'POST'): ?>
        <?php echo method_field($method); ?>
    <?php endif; ?>

    <div>
        <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nama Lengkap Guru *</label>
        <input
            id="name"
            name="name"
            type="text"
            required
            placeholder="Contoh: ADNANSYAH, S.Pd.MM"
            value="<?php echo e(old('name', $teacher->user->name ?? '')); ?>"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
        >
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Alamat Email *</label>
        <input
            id="email"
            name="email"
            type="email"
            required
            placeholder="guru@smpn13.sch.id"
            value="<?php echo e(old('email', $teacher->user->email ?? '')); ?>"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
        >
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password <?php echo e(isset($teacher) ? '(Biarkan kosong jika tidak diubah)' : '*'); ?></label>
        <input
            id="password"
            name="password"
            type="password"
            <?php echo e(isset($teacher) ? '' : 'required'); ?>

            placeholder="Min. 8 Karakter"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
        >
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="nip" class="mb-2 block text-sm font-medium text-slate-700">NIP *</label>
        <input
            id="nip"
            name="nip"
            type="text"
            required
            placeholder="Nomor Induk Pegawai"
            value="<?php echo e(old('nip', $teacher->nip ?? '')); ?>"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
        >
        <?php $__errorArgs = ['nip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="subject_name" class="mb-2 block text-sm font-medium text-slate-700">Mata Pelajaran</label>
        <input
            id="subject_name"
            name="subject_name"
            type="text"
            placeholder="Contoh: PJOK / Matematika / Bahasa Indonesia"
            value="<?php echo e(old('subject_name', $teacher->subject->name ?? '')); ?>"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
        >
        <?php $__errorArgs = ['subject_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="started_at" class="mb-2 block text-sm font-medium text-slate-700">Tanggal Mulai Mengajar</label>
        <input
            id="started_at"
            name="started_at"
            type="date"
            value="<?php echo e(old('started_at', (isset($teacher) && $teacher->started_at) ? $teacher->started_at->format('Y-m-d') : '')); ?>"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-navy focus:ring-2 focus:ring-navy/20"
        >
        <?php $__errorArgs = ['started_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-navy px-5 py-3 text-sm font-semibold text-white transition hover:bg-opacity-90"><?php echo e($submitLabel); ?></button>
        <a href="<?php echo e(route('admin.teachers.index')); ?>" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Batal</a>
    </div>
</form>
<?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/admin/teachers/_form.blade.php ENDPATH**/ ?>