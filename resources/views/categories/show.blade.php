@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">{{ $category->name }}</h1>
                    @if($category->description)
                        <p class="text-muted mt-2">{{ $category->description }}</p>
                    @endif
                </div>
                @auth
                    <div>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i> Edit Category
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Posts in {{ $category->name }} ({{ $posts->total() }})</h5>
                    @auth
                        <a href="{{ route('posts.create') }}?category={{ $category->id }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> New Post
                        </a>
                    @endauth
                </div>
                <div class="card-body">
                    @if($posts->count() > 0)
                        <div class="row">
                            @foreach($posts as $post)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        @if($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" class="card-img-top" 
                                                 style="height: 200px; object-fit: cover;" alt="{{ $post->title }}">
                                        @endif
                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title">
                                                <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">
                                                    {{ $post->title }}
                                                </a>
                                            </h6>
                                            <p class="card-text text-muted small">
                                                {{ Str::limit($post->content, 120) }}
                                            </p>
                                            <div class="mt-auto">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        By {{ $post->user->name }}
                                                    </small>
                                                    <small class="text-muted">
                                                        {{ $post->created_at->format('M j, Y') }}
                                                    </small>
                                                </div>
                                                @if($post->status === 'published')
                                                    <span class="badge bg-success mt-2">Published</span>
                                                @else
                                                    <span class="badge bg-warning mt-2">Draft</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No posts in this category yet</h5>
                            <p class="text-muted">Be the first to create a post in {{ $category->name }}!</p>
                            @auth
                                <a href="{{ route('posts.create') }}?category={{ $category->id }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create First Post
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Categories
            </a>
        </div>
    </div>
</div>
@endsection
