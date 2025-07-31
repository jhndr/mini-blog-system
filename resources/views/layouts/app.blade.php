<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            --secondary-gradient: linear-gradient(135deg, #6c7b7f 0%, #8e9eab 100%);
            --success-gradient: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            --warning-gradient: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            --danger-gradient: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            --light-gradient: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            --card-shadow: 0 5px 15px rgba(0,0,0,0.08);
            --hover-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8f9fa;
            color: #2c3e50;
            line-height: 1.6;
            min-height: 100vh;
        }
        
        .navbar {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1030;
        }
        
        .dropdown-menu {
            z-index: 1040;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 15px;
            padding: 10px;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: white !important;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: white !important;
            transform: translateY(-1px);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: white;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
            left: 0;
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(44, 62, 80, 0.3);
            font-weight: 600;
            border-radius: 8px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(44, 62, 80, 0.4);
            background: var(--primary-gradient);
            border: none;
        }
        
        .btn-outline-primary {
            border: 2px solid #2c3e50;
            background: white;
            color: #2c3e50;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        
        .btn-outline-primary:hover {
            background: #2c3e50;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(44, 62, 80, 0.3);
        }
        
        .btn-success {
            background: var(--success-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        }
        
        .btn-warning {
            background: var(--warning-gradient);
            border: none;
            color: white;
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);
        }
        
        .btn-danger {
            background: var(--danger-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            background: white;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: var(--hover-shadow);
        }
        
        .card-header {
            background: var(--light-gradient);
            border: none;
            padding: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            background: white;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #2c3e50;
            box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.15);
            transform: translateY(-1px);
        }
        
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        /* Custom File Upload Styles */
        .custom-file-upload {
            position: relative;
            display: inline-block;
            cursor: pointer;
            width: 100%;
        }
        
        .custom-file-upload input[type=file] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-upload-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border: 2px dashed #6c757d;
            border-radius: 8px;
            background: #f8f9fa;
            color: #6c757d;
            font-weight: 600;
            transition: all 0.3s ease;
            min-height: 120px;
            flex-direction: column;
            gap: 10px;
        }
        
        .file-upload-btn:hover {
            border-color: #2c3e50;
            background: #e9ecef;
            color: #2c3e50;
            transform: scale(1.01);
        }
        
        .file-upload-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .file-upload-text {
            text-align: center;
        }
        
        .badge {
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.75rem;
        }
        
        .badge.bg-success {
            background: var(--success-gradient) !important;
        }
        
        .badge.bg-warning {
            background: var(--warning-gradient) !important;
            color: #2c3e50 !important;
        }
        
        .badge.bg-danger {
            background: var(--secondary-gradient) !important;
        }
        
        .badge-primary {
            background: var(--primary-gradient) !important;
        }
        
        .badge-secondary {
            background: var(--dark-gradient) !important;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            padding: 6rem 0;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.05"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.5;
        }
        
        .hero-section .display-4 {
            font-weight: 800;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        
        .hero-section .lead {
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .post-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .post-card .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .post-card .card-text {
            flex: 1;
        }
        
        .post-meta {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .sidebar {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            border: none;
        }
        
        html, body {
            height: 100%;
        }
        
        body {
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
        }
        
        .footer {
            background: var(--primary-gradient);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: auto;
            position: relative;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #6c757d 0%, #2c3e50 50%, #6c757d 100%);
        }
        
        .alert {
            border-radius: 8px;
            border: none;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .pagination .page-link {
            color: var(--dark-gray);
            border-color: var(--light-gray);
        }
        
        .pagination .page-link:hover {
            color: var(--medium-gray);
            background-color: #f8f9fa;
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--dark-gray);
            border-color: var(--dark-gray);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-blog me-2"></i>{{ config('app.name', 'Mini Blog') }}
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('welcome') }}">View Website</a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item">
                            @if(auth()->user()->hasRole('admin'))
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                            @else
                                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                            @endif
                        </li>
                        @if(auth()->user()->hasRole('admin'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.posts.index') }}">Post Moderation</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('posts.index') }}">My Posts</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('categories.index') }}">Categories</a>
                        </li>
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('posts.create') }}">
                                    <i class="fas fa-plus me-2"></i>New Post
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>{{ config('app.name', 'Mini Blog') }}</h5>
                    <p>A simple and elegant blog system built with Laravel.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>