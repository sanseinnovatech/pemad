@extends('layouts.app')

@section('title', 'Dashboard')
@section('desc', 'Halaman utama dashboard aplikasi')

@section('content')

<div class="section-body">
    {{-- Welcome Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4><i class="fas fa-home mr-2"></i>Selamat Datang</h4>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="text-primary mb-2">
                                <i class="fas fa-user-circle mr-2"></i>
                                Halo, {{ Auth::user()->name ?? 'User' }}!
                            </h5>
                            <p class="text-muted mb-3">
                                Selamat datang kembali di dashboard {{ env('APP_NAME', 'Aplikasi') }}.
                                Hari ini adalah {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}.
                            </p>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Tip:</strong> Gunakan menu sidebar untuk navigasi ke berbagai fitur aplikasi.
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="dashboard-welcome-icon">
                                <i class="fas fa-chart-line fa-5x text-primary opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Stats Cards --}}
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Users</h4>
                    </div>
                    <div class="card-body">
                        {{ \App\Models\User::count() ?? 0 }}
                    </div>
                </div>
            </div>
        </div>

        @if(class_exists('\App\Models\Product'))
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-box"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Products</h4>
                    </div>
                    <div class="card-body">
                        {{ \App\Models\Product::count() ?? 0 }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(class_exists('\App\Models\Category'))
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Categories</h4>
                    </div>
                    <div class="card-body">
                        {{ \App\Models\Category::count() ?? 0 }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(class_exists('\App\Models\Review'))
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-star"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Reviews</h4>
                    </div>
                    <div class="card-body">
                        {{ \App\Models\Review::count() ?? 0 }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Recent Activity & Quick Actions --}}
    <div class="row">
        <div class="col-lg-8 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-clock mr-2"></i>Aktivitas Terbaru</h4>
                </div>
                <div class="card-body">
                    <div class="activities">
                        <div class="activity">
                            <div class="activity-icon bg-primary text-white shadow-primary">
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2">
                                    <span class="text-job">{{ \Carbon\Carbon::now()->locale('id')->diffForHumans() }}</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">Login</a>
                                </div>
                                <p>Anda berhasil masuk ke sistem</p>
                            </div>
                        </div>
                        <div class="activity">
                            <div class="activity-icon bg-success text-white shadow-success">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2">
                                    <span class="text-job">{{ \Carbon\Carbon::now()->locale('id')->diffForHumans() }}</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">Dashboard</a>
                                </div>
                                <p>Mengakses halaman dashboard</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-bolt mr-2"></i>Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        @can('admin')
                        <a href="{{ route('user.index') }}" class="btn btn-primary btn-block mb-2">
                            <i class="fas fa-users mr-2"></i>Kelola Users
                        </a>
                        @if(Route::has('product.index'))
                        <a href="{{ route('product.index') }}" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-box mr-2"></i>Kelola Products
                        </a>
                        @endif
                        @if(Route::has('category.index'))
                        <a href="{{ route('category.index') }}" class="btn btn-warning btn-block mb-2">
                            <i class="fas fa-tags mr-2"></i>Kelola Categories
                        </a>
                        @endif
                        @else
                        <div class="alert alert-light">
                            <i class="fas fa-info-circle mr-2"></i>
                            Menu admin tidak tersedia untuk role Anda.
                        </div>
                        @endcan
                    </div>
                </div>
            </div>

            {{-- User Info Card --}}
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-user mr-2"></i>Informasi User</h4>
                </div>
                <div class="card-body">
                    <div class="py-4">
                        <div class="text-center mb-3">
                            <div class="avatar avatar-xl bg-primary text-white">
                                <i class="fas fa-user fa-2x"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h6 class="mb-1">{{ Auth::user()->name ?? 'User' }}</h6>
                            <p class="text-muted small mb-2">{{ Auth::user()->email ?? 'user@example.com' }}</p>
                            <span class="badge badge-primary">
                                {{ ucfirst(Auth::user()->role ?? 'user') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .dashboard-welcome-icon {
        opacity: 0.8;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .card-statistic-1 {
        transition: transform 0.3s ease;
    }

    .card-statistic-1:hover {
        transform: translateY(-5px);
    }

    .avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
</style>
@endpush
@endsection
