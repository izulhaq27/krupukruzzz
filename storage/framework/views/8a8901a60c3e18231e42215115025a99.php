<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center shrink-0">
            <i class="bi bi-cart3 text-2xl"></i>
        </div>
        <h2 class="font-extrabold text-2xl md:text-3xl text-slate-900 tracking-tight m-0">Keranjang Belanja</h2>
    </div>
    
    <?php if(empty($cart)): ?>
        <div class="bg-white rounded-3xl p-10 md:p-16 text-center border border-slate-100 shadow-sm animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]">
            <div class="mb-6">
                <i class="bi bi-cart-x text-7xl text-slate-200"></i>
            </div>
            <h3 class="font-bold text-2xl text-slate-800 mb-3">Keranjang Masih Kosong</h3>
            <p class="text-slate-500 max-w-md mx-auto mb-8">Belum ada produk lezat yang Anda tambahkan ke keranjang. Yuk mulai berbelanja!</p>
            <a href="<?php echo e(route('products.index')); ?>" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-6 py-3 rounded-full transition-all duration-200 active:scale-95 shadow-sm shadow-emerald-500/20">
                <i class="bi bi-bag-plus"></i> Mulai Belanja
            </a>
        </div>
    <?php else: ?>
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]">
            <!-- Items Section -->
            <div class="flex-grow lg:w-2/3">
                <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
                    <div class="hidden md:grid grid-cols-12 gap-4 bg-slate-50 border-b border-slate-100 p-5 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <div class="col-span-6">Produk</div>
                        <div class="col-span-3 text-center">Jumlah</div>
                        <div class="col-span-2 text-right">Subtotal</div>
                        <div class="col-span-1"></div>
                    </div>
                    
                    <div class="divide-y divide-slate-100">
                        <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-4 md:p-5 flex flex-col md:grid md:grid-cols-12 md:items-center gap-4 group hover:bg-slate-50/50 transition-colors">
                                <!-- Product Info -->
                                <div class="md:col-span-6 flex items-center gap-4">
                                    <?php if($item['image']): ?>
                                        <img src="<?php echo e(asset('storage/' . $item['image'])); ?>" 
                                             class="w-20 h-20 rounded-2xl object-cover border border-slate-100 shadow-sm shrink-0" 
                                             alt="<?php echo e($item['name']); ?>">
                                    <?php else: ?>
                                        <div class="w-20 h-20 rounded-2xl bg-slate-100 flex items-center justify-center shrink-0 border border-slate-200">
                                            <i class="bi bi-image text-slate-300 text-2xl"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <h6 class="font-bold text-slate-800 mb-1 leading-snug"><?php echo e($item['name']); ?></h6>
                                        <p class="font-semibold text-emerald-500 text-sm">
                                            Rp<?php echo e(number_format($item['price'], 0, ',', '.')); ?>

                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Quantity -->
                                <div class="md:col-span-3 flex md:justify-center items-center">
                                    <form action="<?php echo e(route('cart.update', $id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <div class="flex items-center bg-slate-50 border border-slate-200 rounded-full p-1 w-28">
                                            <button type="button" onclick="decrementQty(this)" class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-slate-600 shadow-sm hover:bg-slate-100 transition-colors shrink-0">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="number" 
                                                   name="quantity" 
                                                   value="<?php echo e($item['quantity']); ?>" 
                                                   min="1" 
                                                   class="w-full bg-transparent border-0 text-center font-bold text-slate-800 text-sm focus:ring-0 p-0 qty-input" readonly>
                                            <button type="button" onclick="incrementQty(this)" class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-slate-600 shadow-sm hover:bg-slate-100 transition-colors shrink-0">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Subtotal -->
                                <div class="md:col-span-2 flex items-center justify-between md:justify-end">
                                    <span class="md:hidden text-slate-500 text-sm">Subtotal:</span>
                                    <strong class="text-slate-900 font-bold">
                                        Rp<?php echo e(number_format($item['price'] * $item['quantity'], 0, ',', '.')); ?>

                                    </strong>
                                </div>
                                
                                <!-- Remove -->
                                <div class="md:col-span-1 flex justify-end">
                                    <form action="<?php echo e(route('cart.remove', $id)); ?>" method="POST" class="w-full md:w-auto">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                                class="w-full md:w-9 md:h-9 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl flex items-center justify-center gap-2 transition-colors focus:outline-none py-2 md:py-0"
                                                onclick="return confirm('Hapus produk dari keranjang?')"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                            <span class="md:hidden font-medium text-sm">Hapus Item</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                
                <div class="mt-6 hidden md:block">
                    <a href="<?php echo e(route('products.index')); ?>" class="inline-flex items-center gap-2 bg-white border-2 border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50 px-6 py-3 rounded-full font-bold transition-all duration-200">
                        <i class="bi bi-arrow-left"></i> Lanjut Belanja
                    </a>
                </div>
            </div>
            
            <!-- Summary Card -->
            <div class="lg:w-1/3 shrink-0">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm sticky top-24 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h5 class="font-extrabold text-lg text-slate-900 m-0">
                            Ringkasan Belanja
                        </h5>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4 text-sm">
                            <span class="text-slate-500">Total Item</span>
                            <span class="font-semibold text-slate-800"><?php echo e(count($cart)); ?> Item</span>
                        </div>
                        <div class="flex justify-between items-center mb-4 text-sm">
                            <span class="text-slate-500">Subtotal</span>
                            <span class="font-semibold text-slate-800">Rp<?php echo e(number_format($total, 0, ',', '.')); ?></span>
                        </div>
                        <div class="flex justify-between items-center mb-6 pb-6 border-b border-slate-100 text-sm">
                            <span class="text-slate-500">Ongkos Kirim</span>
                            <span class="font-medium px-2 py-1 bg-emerald-50 text-emerald-600 rounded-md text-xs">
                                Dihitung saat checkout
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-end mb-8">
                            <strong class="text-slate-900 font-bold">Total Harga</strong>
                            <strong class="text-2xl text-emerald-500 font-extrabold leading-none">
                                Rp<?php echo e(number_format($total, 0, ',', '.')); ?>

                            </strong>
                        </div>
                        
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('checkout.index')); ?>" class="w-full flex items-center justify-center bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 px-6 rounded-full transition-all duration-200 active:scale-95 shadow-sm shadow-emerald-500/20">
                                Lanjut ke Checkout
                            </a>
                        <?php else: ?>
                            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-xl flex gap-3 items-start mb-6">
                                <i class="bi bi-info-circle-fill text-amber-500 mt-0.5"></i>
                                <div>
                                    <p class="font-bold text-amber-900 text-sm">Akses Terbatas</p>
                                    <p class="text-xs text-amber-700 mt-1">Silakan login atau daftar untuk melanjutkan checkout.</p>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3">
                                <a href="<?php echo e(route('login')); ?>" class="w-full flex items-center justify-center bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-6 rounded-full transition-all duration-200 active:scale-95">
                                    Login
                                </a>
                                <a href="<?php echo e(route('register')); ?>" class="w-full flex items-center justify-center bg-white border-2 border-emerald-500 text-emerald-600 hover:bg-emerald-50 font-bold py-3 px-6 rounded-full transition-all duration-200 active:scale-95">
                                    Daftar Akun Baru
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function incrementQty(button) {
        const form = button.closest('form');
        const input = form.querySelector('.qty-input');
        input.value = parseInt(input.value) + 1;
        form.submit();
    }
    
    function decrementQty(button) {
        const form = button.closest('form');
        const input = form.querySelector('.qty-input');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            form.submit();
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/cart/index.blade.php ENDPATH**/ ?>