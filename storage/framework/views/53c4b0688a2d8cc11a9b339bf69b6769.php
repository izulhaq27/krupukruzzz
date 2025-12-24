<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - KrupuKruzz</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #F1F5F9; /* TailAdmin Light BG */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #ffffff;
            border-radius: 4px; /* Sharper corners for admin tool feel */
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }

        .brand-logo {
            background: #3C50E0; 
            border-radius: 8px; 
            display: inline-flex; /* Changed from flex to inline-flex to hug content or stay centered */
            align-items: center; 
            justify-content: center; 
            color: white; 
            padding: 10px 20px; /* Added padding for spacing */
            margin: 0 auto 1rem auto;
            /* Removed fixed width/height */
        }

        .brand-logo h1 {
            margin: 0;
            font-size: 1.5rem; /* Adjusted font size */
            font-weight: 700;
            line-height: 1;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #3C50E0;
            box-shadow: 0 0 0 2px rgba(60, 80, 224, 0.1);
        }

        .btn-primary {
            background-color: #3C50E0;
            border-color: #3C50E0;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #3141bd;
            border-color: #3141bd;
        }

        .input-group-text {
            background-color: #f8fafc;
            border-color: #e2e8f0;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="text-center mb-5">
            <div class="brand-logo">
                <h1>KrupuKruzzz</h1>
            </div>
            <h4 class="fw-bold" style="color: #1e293b;">Sign In to Admin</h4>
            <p class="text-muted small">Enter your details to proceed</p>
        </div>

        <?php if(session('error')): ?>
            <div class="alert alert-danger text-center fs-6 py-2 mb-4">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.login.submit')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="admin@krupuk.com" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-4 shadow-sm">
                Sign In
            </button>
        </form>
    </div>

</body>
</html><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/admin/login.blade.php ENDPATH**/ ?>