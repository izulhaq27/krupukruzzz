<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4 animate-fade-in-up">
            <div class="text-center mb-4">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" style="height: 64px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));" class="mb-3">
                <h2 class="fw-bold" style="color: var(--cm-neutral-900);">Selamat Datang</h2>
                <p style="color: var(--cm-neutral-500);">Masuk ke akun KrupuKruzzz Anda</p>
            </div>

            <div class="cm-card overflow-hidden" style="border-radius: var(--cm-radius-xl); border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.06);">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold" style="color: var(--cm-neutral-700); font-size: 0.9rem;">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="color: var(--cm-neutral-400); border-radius: var(--cm-radius-sm) 0 0 var(--cm-radius-sm);">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input id="email" type="email" class="form-control border-start-0 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus placeholder="nama@email.com" style="border-radius: 0 var(--cm-radius-sm) var(--cm-radius-sm) 0;">
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
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label fw-semibold mb-0" style="color: var(--cm-neutral-700); font-size: 0.9rem;">Password</label>
                                <?php if(Route::has('password.request')): ?>
                                    <a class="text-decoration-none fw-medium" style="font-size: 0.85rem; color: var(--cm-primary);" href="<?php echo e(route('password.request')); ?>">
                                        Lupa Password?
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="color: var(--cm-neutral-400); border-radius: var(--cm-radius-sm) 0 0 var(--cm-radius-sm);">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input id="password" type="password" class="form-control border-start-0 border-end-0 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password" placeholder="••••••••" style="border-radius: 0;">
                                <button class="btn btn-outline-secondary border-start-0 bg-white" type="button" id="togglePassword" style="border-radius: 0 var(--cm-radius-sm) var(--cm-radius-sm) 0; border-color: var(--cm-neutral-200); color: var(--cm-neutral-400);">
                                    <i class="bi bi-eye"></i>
                                </button>
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
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?> style="border-color: var(--cm-neutral-300);">
                                <label class="form-check-label" for="remember" style="color: var(--cm-neutral-600); font-size: 0.9rem;">
                                    Ingat Saya
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-cm-primary btn-cm-pill py-2 py-md-3 fw-bold fs-6">
                                Masuk <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>
                        
                        <div class="text-center">
                            <p style="color: var(--cm-neutral-500); font-size: 0.9rem;">Belum punya akun? 
                                <a href="<?php echo e(route('register')); ?>" class="text-decoration-none fw-bold" style="color: var(--cm-secondary-dark);">Daftar Sekarang</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        if(togglePassword && password) {
            togglePassword.addEventListener('click', function (e) {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/auth/login.blade.php ENDPATH**/ ?>