@extends('layouts.app')

@section('content')
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
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold" style="color: #333;">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <input id="email" 
                                   type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus
                                   placeholder="nama@email.com"
                                   style="border-radius: 8px;">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold" style="color: #333;">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input id="password" 
                                   type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="Masukkan password"
                                   style="border-radius: 8px;">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="remember" 
                                       id="remember" 
                                       {{ old('remember') ? 'checked' : '' }}>
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
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small" href="{{ route('password.request') }}" style="color: #28a745;">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-0" style="color: #666;">Belum punya akun? 
                                <a href="{{ route('register') }}" class="fw-semibold text-decoration-none" style="color: #28a745;">
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
@endsection