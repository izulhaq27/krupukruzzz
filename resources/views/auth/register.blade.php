@extends('layouts.app')

@section('content')
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
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold" style="color: #333;">
                                <i class="bi bi-person"></i> Nama Lengkap
                            </label>
                            <input id="name" 
                                   type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autocomplete="name" 
                                   autofocus
                                   placeholder="Masukkan nama lengkap"
                                   style="border-radius: 8px;">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

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
                                   autocomplete="new-password"
                                   placeholder="Minimal 8 karakter"
                                   style="border-radius: 8px;">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
                                <a href="{{ route('login') }}" class="fw-semibold text-decoration-none" style="color: #28a745;">
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
@endsection