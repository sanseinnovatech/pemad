@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <!-- Login Brand -->
                <div class="login-brand text-center mb-4">
                    <div class="brand-container">
                        <img src="{{ asset('assets/img/pemad.png') }}"
                             alt="{{ env('APP_NAME', 'PEMAD') }}"
                             width="80"
                             height="80"
                             class="brand-logo">
                        <h3 class="brand-name mt-3">{{ env('APP_NAME', 'PEMAD') }}</h3>
                        <p class="brand-tagline text-muted">Platform E-commerce Modern</p>
                    </div>
                </div>

                <!-- Login Card -->
                <div class="card card-primary shadow-lg border-0">
                    <div class="card-header bg-gradient-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk ke Akun Anda
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        <!-- Welcome Message -->
                        <div class="text-center mb-4">
                            <h5 class="text-dark">Selamat Datang Kembali!</h5>
                            <p class="text-muted small">Silakan masuk untuk melanjutkan belanja</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}" autocomplete="off">
                            @csrf

                            <!-- Email/Username Field -->
                            <div class="form-group">
                                <label for="email" class="font-weight-bold">
                                    <i class="fas fa-envelope mr-1"></i>
                                    Email/Username
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <input id="email"
                                           type="text"
                                           class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           name="email"
                                           placeholder="Masukkan email atau username"
                                           tabindex="1"
                                           autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="password" class="font-weight-bold mb-0">
                                        <i class="fas fa-lock mr-1"></i>
                                        Password
                                    </label>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    <input id="password"
                                           type="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           name="password"
                                           placeholder="Masukkan password"
                                           tabindex="2">
                                    <div class="input-group-append">
                                        <div class="input-group-text password-toggle" style="cursor: pointer;">
                                            <i class="fas fa-eye" id="togglePassword"></i>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"
                                           class="custom-control-input"
                                           id="remember"
                                           name="remember">
                                    <label class="custom-control-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                            </div>

                            <!-- Login Button -->
                            <div class="form-group mb-3">
                                <button type="submit"
                                        class="btn btn-primary btn-lg btn-block btn-gradient"
                                        tabindex="4">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Masuk Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <div class="simple-footer text-center mt-4">
                    <div class="text-muted small">
                        <p class="mb-1">
                            Copyright &copy; {{ date('Y') }}
                            <span class="font-weight-bold text-primary">{{ env('APP_NAME', 'PEMAD') }}</span>
                        </p>
                        <p class="mb-0">
                            Made with <i class="fas fa-heart text-danger"></i> by PEMAD Team
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    /* Custom Styles */
    .section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .brand-container {
        animation: fadeInDown 1s ease-out;
    }

    .brand-logo {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        object-fit: contain;
        background: white;
        padding: 10px;
        animation: float 3s ease-in-out infinite;
    }

    .brand-name {
        color: #fff;
        font-weight: 800;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        margin-bottom: 0;
    }

    .brand-tagline {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.9rem;
    }

    .card {
        border-radius: 20px;
        animation: fadeInUp 1s ease-out;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }

    .card-header {
        border-radius: 20px 20px 0 0 !important;
        background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%) !important;
        border: none;
        padding: 1.5rem;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%) !important;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        padding: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        background: linear-gradient(135deg, #3730a3 0%, #0891b2 100%);
    }

    .form-control-lg {
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control-lg:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        transform: translateY(-1px);
    }

    .input-group-text {
        border-radius: 10px 0 0 10px;
        border: 2px solid #e5e7eb;
        border-right: none;
        background: #f8fafc;
        color: #6b7280;
    }

    .password-toggle:hover {
        background: #e5e7eb !important;
        color: #4f46e5 !important;
    }

    .custom-control-label::before {
        border-radius: 6px;
        border: 2px solid #4f46e5;
    }

    .custom-control-input:checked ~ .custom-control-label::before {
        background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
        border-color: #4f46e5;
    }

    .btn-outline-danger, .btn-outline-primary {
        border-radius: 8px;
        border-width: 2px;
        font-weight: 600;
        padding: 8px 12px;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover, .btn-outline-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
        }

        .brand-name {
            font-size: 1.8rem;
        }
    }

    /* Loading Animation */
    .btn-gradient:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }

    /* Focus states */
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        border-color: #4f46e5;
    }

    /* Alert styles */
    .invalid-feedback {
        font-weight: 500;
        font-size: 0.875rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password toggle functionality
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        if (togglePassword && passwordField) {
            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);

                // Toggle eye icon
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        // Form submission loading state
        const loginForm = document.querySelector('form');
        const submitButton = document.querySelector('button[type="submit"]');

        if (loginForm && submitButton) {
            loginForm.addEventListener('submit', function() {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            });
        }

        // Auto focus on first input
        const emailField = document.getElementById('email');
        if (emailField) {
            emailField.focus();
        }

        // Add floating label effect
        document.querySelectorAll('.form-control').forEach(function(input) {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (this.value === '') {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    });
</script>
@endpush
@endsection
