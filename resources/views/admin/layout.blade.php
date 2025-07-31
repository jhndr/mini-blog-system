<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }} - Admin Dashboard</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-gray-900 text-white w-64 min-h-screen p-4 fixed lg:relative lg:translate-x-0 transform transition-transform duration-200 ease-in-out z-30"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            
            <!-- Logo -->
            <div class="flex items-center mb-8">
                <div class="text-xl font-bold">
                    <i class="fas fa-blog mr-2"></i>
                    {{ config('app.name', 'Laravel') }}
                </div>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.posts.index') }}" 
                   class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors {{ request()->routeIs('admin.posts.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-edit mr-3"></i>
                    Post Moderation
                </a>
                
                <a href="{{ route('categories.index') }}" 
                   class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-tags mr-3"></i>
                    Categories
                </a>
                
                <div class="border-t border-gray-700 my-4"></div>
                
                <a href="{{ route('home') }}" 
                   class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-globe mr-3"></i>
                    View Website
                </a>
            </nav>

            <!-- User Section -->
            <div class="absolute bottom-4 left-4 right-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-400">Administrator</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="ml-2">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-gray-600 bg-opacity-75 lg:hidden z-20"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-4 py-4">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" 
                                class="text-gray-500 hover:text-gray-600 lg:hidden">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="ml-4 lg:ml-0 text-2xl font-semibold text-gray-900">
                            @yield('page-title', 'Admin Dashboard')
                        </h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" 
                                    class="text-gray-500 hover:text-gray-700 relative">
                                <i class="fas fa-bell text-xl"></i>
                                @if($pending_posts ?? 0 > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ $pending_posts ?? 0 }}
                                    </span>
                                @endif
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50">
                                <div class="p-4">
                                    <h3 class="text-lg font-medium">Notifications</h3>
                                    @if($pending_posts ?? 0 > 0)
                                        <p class="text-sm text-gray-600 mt-2">
                                            You have {{ $pending_posts }} posts waiting for moderation.
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-600 mt-2">No new notifications.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-6 py-8">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js and any additional scripts -->
    @stack('scripts')
</body>
</html>
