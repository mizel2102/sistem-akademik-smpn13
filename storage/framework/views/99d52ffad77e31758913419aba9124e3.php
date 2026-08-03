<?php $__env->startSection('title', 'Berita - SMPN 13 Sungai Raya | Portal Akademik Digital'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('partials.page-hero', [
        'subtitle' => 'INFORMASI TERKINI',
        'title' => 'Berita & Pengumuman',
        'description' => 'Dapatkan informasi terbaru mengenai kegiatan, prestasi, dan pengumuman penting dari lingkungan SMPN 13 Sungai Raya.'
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- FILTER SECTION -->
    <section class="py-6 px-4 sm:px-6 lg:px-8 border-b border-slate-200 bg-white">
        <form action="<?php echo e(route('berita.index')); ?>" method="GET" class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="text-lg font-bold text-slate-800">Cari Berita</h2>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="keyword" value="<?php echo e(request('keyword')); ?>" placeholder="Kata kunci..." class="w-full pl-9 pr-3 py-2 text-sm border border-slate-300 rounded-full focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-shadow shadow-sm">
                </div>
                <select name="category" onchange="this.form.submit()" class="px-4 py-2 text-sm border border-slate-300 rounded-full focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm bg-white text-slate-700 w-full sm:w-auto">
                    <option value="Semua Kategori">Semua Kategori</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category); ?>" <?php echo e(request('category') == $category ? 'selected' : ''); ?>><?php echo e($category); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="submit" class="hidden sm:block px-4 py-2 bg-blue-900 text-white rounded-full text-sm hover:bg-blue-800">Cari</button>
            </div>
        </form>
    </section>

    <!-- CONTENT SECTION (Card Grid) -->
    <section class="py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 min-h-[50vh]">
        <div class="max-w-7xl mx-auto">
            <?php if($posts->count() > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300 group flex flex-col">
                        <div class="h-48 bg-slate-200 overflow-hidden relative">
                            <?php if($post->image): ?>
                                <img src="<?php echo e(asset('storage/' . $post->image)); ?>" alt="<?php echo e($post->title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <?php else: ?>
                                <div class="absolute inset-0 flex items-center justify-center text-slate-400 group-hover:scale-105 transition-transform duration-500 bg-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                            <?php endif; ?>
                            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-md text-xs font-bold text-blue-900 uppercase tracking-wider shadow-sm">
                                <?php echo e($post->category); ?>

                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <p class="text-xs text-slate-500 font-medium mb-2"><?php echo e($post->published_at->format('d M Y')); ?> &bull; <?php echo e($post->user->name); ?></p>
                            <h3 class="text-lg font-bold text-slate-900 leading-tight mb-3 group-hover:text-blue-700 transition-colors"><?php echo e($post->title); ?></h3>
                            <p class="text-sm text-slate-600 line-clamp-3 mb-4 flex-1"><?php echo e(Str::limit(strip_tags($post->content), 120)); ?></p>
                            <a href="<?php echo e(route('berita.show', $post->slug)); ?>" class="inline-flex items-center text-sm font-bold text-sky-600 hover:text-sky-700">
                                Baca Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- PAGINATION -->
                <div class="mt-12">
                    <?php echo e($posts->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-16">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold text-slate-800">Tidak Ada Berita Ditemukan</h3>
                    <p class="text-slate-500 mt-2">Coba ubah kata kunci atau kategori pencarian Anda.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-akademik-smpn13\resources\views/berita/index.blade.php ENDPATH**/ ?>