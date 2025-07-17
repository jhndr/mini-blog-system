@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <article class="card">
                @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         class="card-img-top" alt="{{ $post->title }}" style="height: 300px; object-fit: cover;">
                @endif
                
                <div class="card-body">
                    <div class="mb-3">
                        <span class="badge bg-primary">{{ $post->category->name }}</span>
                        @if(!$post->is_published)
                            <span class="badge bg-warning">Draft</span>
                        @endif
                    </div>
                    
                    <h1 class="card-title">{{ $post->title }}</h1>
                    
                    <div class="post-meta mb-4">
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i>{{ $post->user->name }}
                            @if($post->is_published && $post->published_at)
                                <i class="fas fa-calendar ms-3 me-1"></i>{{ $post->published_at->format('F d, Y') }}
                            @else
                                <i class="fas fa-calendar ms-3 me-1"></i>Created {{ $post->created_at->format('F d, Y') }}
                            @endif
                        </small>
                    </div>
                    
                    <div class="post-excerpt mb-4">
                        <p class="lead">{{ $post->excerpt }}</p>
                    </div>
                    
                    <div class="post-content">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
                
                @if($post->user_id === auth()->id())
                    <div class="card-footer">
                        <div class="btn-group">
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-edit me-1"></i>Edit Post
                            </a>
                            <a href="{{ route('posts.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-1"></i>Back to My Posts
                            </a>
                        </div>
                    </div>
                @endif
            </article>
            
            @if($post->is_published)
                <div class="mt-4 text-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Home
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
