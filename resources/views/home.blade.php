@extends('layouts.app')

@section('content')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold mb-4">Welcome to Our Blog</h1>
                <p class="lead mb-4">Discover amazing stories, insights, and ideas from our community of writers.</p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">Get Started</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">Login</a>
                @endguest
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="fas fa-blog" style="font-size: 8rem; color: var(--medium-gray);"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Latest Posts</h2>
                @auth
                    <a href="{{ route('posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>New Post
                    </a>
                @endauth
            </div>

            @if($posts->count() > 0)
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-6 mb-4">
                            <div class="card post-card">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                         class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <p class="card-text">{{ $post->excerpt }}</p>
                                    <div class="post-meta mb-3">
                                        <small>
                                            <i class="fas fa-user me-1"></i>{{ $post->user->name }}
                                            @if($post->published_at)
                                                <i class="fas fa-calendar ms-3 me-1"></i>{{ $post->published_at->format('M d, Y') }}
                                            @endif
                                            <i class="fas fa-tag ms-3 me-1"></i>{{ $post->category->name }}
                                        </small>
                                    </div>
                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                    <h5>No posts available</h5>
                    <p class="text-muted">Be the first to share your story!</p>
                    @auth
                        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
                    @endauth
                </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <div class="sidebar">
                <h5 class="mb-3">Categories</h5>
                @if($categories->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($categories as $category)
                            <a href="{{ route('categories.show', $category) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                {{ $category->name }}
                                <span class="badge badge-primary">{{ $category->posts_count }}</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No categories available.</p>
                @endif
                
                <hr class="my-4">
                
                <h5 class="mb-3">About</h5>
                <p class="text-muted">Welcome to our blog community! Share your thoughts, experiences, and insights with fellow readers.</p>
                
                @guest
                    <div class="mt-4">
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm me-2">Join Us</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Login</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection
