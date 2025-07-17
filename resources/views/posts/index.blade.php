@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>My Posts</h1>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>New Post
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($posts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Published</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $post)
                                        <tr>
                                            <td>
                                                <strong>{{ $post->title }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($post->excerpt, 60) }}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $post->category->name }}</span>
                                            </td>
                                            <td>
                                                @if($post->is_published)
                                                    <span class="badge bg-success">Published</span>
                                                @else
                                                    <span class="badge bg-warning">Draft</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not published' }}
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    @if($post->is_published)
                                                        <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-secondary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="d-inline" 
                                                          onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                            <h5>No posts yet</h5>
                            <p class="text-muted">Start by creating your first post!</p>
                            <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
