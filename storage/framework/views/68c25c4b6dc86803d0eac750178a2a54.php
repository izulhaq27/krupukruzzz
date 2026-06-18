<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5 animate-fade-in-up">
            <div class="text-center mb-4">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" style="height: 64px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));" class="mb-3">
                <h2 class="fw-bold" style="color: var(--cm-neutral-900);">Daftar Akun Baru</h2>
                <p style="color: var(--cm-neutral-500);">Bergabunglah dan nikmati kerupuk kualitas premium</p>
            </div>

            <div class="cm-card overflow-hidden" style="border-radius: var(--cm-radius-xl); border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.06);">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="<?php echo e(route('register')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold" style="color: var(--cm-neutral-700); font-size: 0.9rem;">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="color: var(--cm-neutral-400); border-radius: var(--cm-radius-sm) 0 0 var(--cm-radius-sm);">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input id="name" type="text" class="form-control border-start-0 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name')); ?>" required autocomplete="name" autofocus placeholder="Nama Lengkap" style="border-radius: 0 var(--cm-radius-sm) var(--cm-radius-sm) 0;">
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
                        </div>

                        <div class="mb-3">
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
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" placeholder="nama@email.com" style="border-radius: 0 var(--cm-radius-sm) var(--cm-radius-sm) 0;">
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

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold" style="color: var(--cm-neutral-700); font-size: 0.9rem;">Nomor Telepon/WA</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="color: var(--cm-neutral-400); border-radius: var(--cm-radius-sm) 0 0 var(--cm-radius-sm);">
                                    <i class="bi bi-phone"></i>
                                </span>
                                <input id="phone" type="text" class="form-control border-start-0 <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="phone" value="<?php echo e(old('phone')); ?>" autocomplete="tel" placeholder="08xxxxxxxxx" style="border-radius: 0 var(--cm-radius-sm) var(--cm-radius-sm) 0;">
                                <?php $__errorArgs = ['phone'];
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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-semibold" style="color: var(--cm-neutral-700); font-size: 0.9rem;">Password</label>
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
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="new-password" placeholder="••••••••" style="border-radius: 0;">
                                    <button class="btn btn-outline-secondary border-start-0 bg-white" type="button" onclick="togglePasswordVisibility('password', this)" style="border-radius: 0 var(--cm-radius-sm) var(--cm-radius-sm) 0; border-color: var(--cm-neutral-200); color: var(--cm-neutral-400);">
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

                            <div class="col-md-6 mb-4">
                                <label for="password-confirm" class="form-label fw-semibold" style="color: var(--cm-neutral-700); font-size: 0.9rem;">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0" style="color: var(--cm-neutral-400); border-radius: var(--cm-radius-sm) 0 0 var(--cm-radius-sm);">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input id="password-confirm" type="password" class="form-control border-start-0 border-end-0" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" style="border-radius: 0;">
                                    <button class="btn btn-outline-secondary border-start-0 bg-white" type="button" onclick="togglePasswordVisibility('password-confirm', this)" style="border-radius: 0 var(--cm-radius-sm) var(--cm-radius-sm) 0; border-color: var(--cm-neutral-200); color: var(--cm-neutral-400);">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required style="border-color: var(--cm-neutral-300);">
                                <label class="form-check-label" for="terms" style="color: var(--cm-neutral-600); font-size: 0.85rem;">
                                    Saya setuju dengan <a href="#" class="text-decoration-none" style="color: var(--cm-primary);">Syarat & Ketentuan</a> serta <a href="#" class="text-decoration-none" style="color: var(--cm-primary);">Kebijakan Privasi</a> KrupuKruzzz
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-cm-primary btn-cm-pill py-2 py-md-3 fw-bold fs-6">
                                Daftar Akun
                            </button>
                        </div>
                        
                        <div class="text-center">
                            <p style="color: var(--cm-neutral-500); font-size: 0.9rem;">Sudah punya akun? 
                                <a href="<?php echo e(route('login')); ?>" class="text-decoration-none fw-bold" style="color: var(--cm-secondary-dark);">Masuk di sini</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, button) {
        const input = document.getElementById(inputId);
        if(input) {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
            const icon = button.querySelector('i');
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/auth/register.blade.php ENDPATH**/ ?>