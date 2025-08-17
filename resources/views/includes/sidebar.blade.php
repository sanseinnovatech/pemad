<?php
?>
<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" aria-label="{{ env('APP_NAME') }}"
           style="display:flex;align-items:center;padding:15px 20px;">
            <img src="{{ asset('assets/img/pemad.png') }}"
                 alt="{{ env('APP_NAME') }}"
                 style="height:70px;width:70px;margin-right:15px;object-fit:contain;flex-shrink:0;">
            <span style="font-size:18px;font-weight:600;">{{ env('APP_NAME') }}</span>
        </a>
    </div>

    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('dashboard') }}" aria-label="{{ config('app.name') }}"
           style="display:flex;align-items:center;justify-content:center;height:80px;padding:10px;">
            <img
                src="/assets/img/pemad.png?v={{ @filemtime(public_path('assets/img/pemad.png')) }}"
                alt="{{ config('app.name') }}"
                style="height:60px !important;width:60px !important;display:block;object-fit:contain;"
            >
        </a>
    </div>

    <ul class="sidebar-menu">
        <li class="menu-header">Main Menu</li>
        <li class="{{ Route::is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fire"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @can('admin')
            <li class="menu-header">Administrator</li>

            <li class="{{ Route::is('user*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Manage Users</span>
                </a>
            </li>
            <li class="nav-item dropdown {{ Route::is('product*') || Route::is('category*') || Route::is('review*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-box-open"></i> <span>Manage Products</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('product.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('product.index') }}">
                            <i class="fas fa-box"></i> <span>Products</span>
                        </a>
                    </li>
                    <li class="{{ Route::is('category*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('category.index') }}">
                            <i class="fas fa-tags"></i> <span>Categories</span>
                        </a>
                    </li>
                    <li class="{{ Route::is('review*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('review.index') }}">
                            <i class="fas fa-star"></i> <span>Reviews</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
    </ul>
</aside>
