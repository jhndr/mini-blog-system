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
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            --light-gradient: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
            --hover-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #2c3e50;
            line-height: 1.6;
            min-height: 100vh;
        }
        
        .navbar {
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
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
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
            background: var(--primary-gradient);
            border: none;
        }
        
        .btn-primary:hover {
            background-color: var(--medium-gray);
            border-color: var(--medium-gray);
        }
        
        .btn-outline-primary {
            color: var(--dark-gray);
            border-color: var(--dark-gray);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--dark-gray);
            border-color: var(--dark-gray);
        }
        
        .card {
            border: 1px solid var(--light-gray);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.15);
        }
        
        .card-header {
            background-color: var(--primary-white);
            border-bottom: 1px solid var(--light-gray);
            font-weight: 600;
        }
        
        .form-control {
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--dark-gray);
            box-shadow: 0 0 0 0.2rem rgba(43, 43, 43, 0.25);
        }
        
        .badge {
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }
        
        .badge-primary {
            background-color: var(--dark-gray);
        }
        
        .badge-secondary {
            background-color: var(--medium-gray);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-white) 0%, #f8f9fa 100%);
            padding: 4rem 0;
            border-bottom: 1px solid var(--light-gray);
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
            color: var(--medium-gray);
            font-size: 0.9rem;
        }
        
        .sidebar {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--light-gray);
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
            background-color: var(--dark-gray);
            color: var(--primary-white);
            padding: 3rem 0 1rem;
            margin-top: auto;
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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('posts.index') }}">My Posts</a>
                        </li>
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