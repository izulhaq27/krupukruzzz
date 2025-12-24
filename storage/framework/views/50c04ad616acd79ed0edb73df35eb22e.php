<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm" style="
                border-radius: 12px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            ">
                <div class="card-header text-center text-white py-3" style="
                    background: #28a745;
                    border-radius: 12px 12px 0 0;
                ">
                    <i class="bi bi-box-arrow-in-right"></i> 
                    <span class="fw-bold fs-5">Login</span>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold" style="color: #333;">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <input id="email" 
                                   type="email" 
                                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   name="email" 
                                   value="<?php echo e(old('email')); ?>" 
                                   required 
                                   autocomplete="email" 
                                   autofocus
                                   placeholder="nama@email.com"
                                   style="border-radius: 8px;">

                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold" style="color: #333;">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input id="password" 
                                   type="password" 
                                   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="Masukkan password"
                                   style="border-radius: 8px;">

                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="remember" 
                                       id="remember" 
                                       <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="remember" style="color: #666;">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-lg text-white fw-semibold" style="
                                background: #28a745;
                                border-radius: 8px;
                                border: none;
                                padding: 12px;
                            ">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                        </div>

                        <div class="text-center mb-3">
                            <?php if(Route::has('password.request')): ?>
                                <a class="text-decoration-none small" href="<?php echo e(route('password.request')); ?>" style="color: #28a745;">
                                    Lupa Password?
                                </a>
                            <?php endif; ?>
                        </div>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-0" style="color: #666;">Belum punya akun? 
                                <a href="<?php echo e(route('register')); ?>" class="fw-semibold text-decoration-none" style="color: #28a745;">
                                    Daftar Sekarang
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/auth/login.blade.php ENDPATH**/ ?>