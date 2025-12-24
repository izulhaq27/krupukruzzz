

<?php $__env->startSection('title', 'Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">💳 Pembayaran</h4>
                </div>
                <div class="card-body text-center">
                    <h5 class="mb-3">Order #<?php echo e($order->order_number); ?></h5>
                    <p class="text-muted">Total: Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></p>
                    
                    <?php if($snapToken): ?>
                        <div id="snap-container"></div>
                        
                        <script type="text/javascript"
                            src="https://app.sandbox.midtrans.com/snap/snap.js"
                            data-client-key="<?php echo e(config('services.midtrans.client_key')); ?>">
                        </script>
                        
                        <script type="text/javascript">
                            window.snap.pay('<?php echo e($snapToken); ?>', {
                                onSuccess: function(result){
                                    window.location.href = "<?php echo e(route('checkout.success')); ?>?order_id=<?php echo e($order->order_number); ?>";
                                },
                                onPending: function(result){
                                    alert("Menunggu pembayaran!");
                                    window.location.href = "<?php echo e(route('checkout.success')); ?>?order_id=<?php echo e($order->order_number); ?>";
                                },
                                onError: function(result){
                                    alert("Pembayaran gagal!");
                                    window.location.href = "<?php echo e(route('checkout.index')); ?>";
                                },
                                onClose: function(){
                                    alert("Popup ditutup tanpa menyelesaikan pembayaran!");
                                }
                            });
                        </script>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            Token pembayaran tidak tersedia. Silakan hubungi admin.
                        </div>
                        <a href="<?php echo e(route('checkout.success')); ?>?order_id=<?php echo e($order->order_number); ?>" 
                           class="btn btn-primary">
                            Lanjutkan Tanpa Pembayaran (Testing)
                        </a>
                    <?php endif; ?>
                    
                    <div class="mt-4">
                        <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/checkout/payment.blade.php ENDPATH**/ ?>