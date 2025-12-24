<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm" style="
                border-radius: 12px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            ">
                <div class="card-header text-center text-white py-3" style="
                    background: #28a745;
                    border-radius: 12px 12px 0 0;
                ">
                    <i class="bi bi-person-plus"></i> 
                    <span class="fw-bold fs-5">Register</span>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="<?php echo e(route('register')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold" style="color: #333;">
                                <i class="bi bi-person"></i> Nama Lengkap
                            </label>
                            <input id="name" 
                                   type="text" 
                                   class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   name="name" 
                                   value="<?php echo e(old('name')); ?>" 
                                   required 
                                   autocomplete="name" 
                                   autofocus
                                   placeholder="Masukkan nama lengkap"
                                   style="border-radius: 8px;">

                            <?php $__errorArgs = ['name'];
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
                                   autocomplete="new-password"
                                   placeholder="Minimal 8 karakter"
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
                            <label for="password-confirm" class="form-label fw-semibold" style="color: #333;">
                                <i class="bi bi-lock-fill"></i> Konfirmasi Password
                            </label>
                            <input id="password-confirm" 
                                   type="password" 
                                   class="form-control" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Ketik ulang password"
                                   style="border-radius: 8px;">
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-lg text-white fw-semibold" style="
                                background: #28a745;
                                border-radius: 8px;
                                border: none;
                                padding: 12px;
                            ">
                                <i class="bi bi-person-plus"></i> Daftar Sekarang
                            </button>
                        </div>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-0" style="color: #666;">Sudah punya akun? 
                                <a href="<?php echo e(route('login')); ?>" class="fw-semibold text-decoration-none" style="color: #28a745;">
                                    Login Sekarang
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/auth/register.blade.php ENDPATH**/ ?>