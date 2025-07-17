@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Dashboard</h1>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>New Post
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); color: white; border: none;">
                <div class="card-body text-center" style="padding: 2rem;">
                    <i class="fas fa-file-alt fa-3x mb-3" style="opacity: 0.9;"></i>
                    <h2 style="font-weight: 700; font-size: 2.5rem; margin: 0;">{{ $totalPosts }}</h2>
                    <p class="mb-0" style="font-weight: 500; opacity: 0.9;">Total Posts</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); color: white; border: none;">
                <div class="card-body text-center" style="padding: 2rem;">
                    <i class="fas fa-eye fa-3x mb-3" style="opacity: 0.9;"></i>
                    <h2 style="font-weight: 700; font-size: 2.5rem; margin: 0;">{{ $publishedPosts }}</h2>
                    <p class="mb-0" style="font-weight: 500; opacity: 0.9;">Published</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; border: none;">
                <div class="card-body text-center" style="padding: 2rem;">
                    <i class="fas fa-edit fa-3x mb-3" style="opacity: 0.9;"></i>
                    <h2 style="font-weight: 700; font-size: 2.5rem; margin: 0;">{{ $draftPosts }}</h2>
                    <p class="mb-0" style="font-weight: 500; opacity: 0.9;">Drafts</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Posts</h5>
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
                <div class="card-body">
                    @if($posts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $post)
                                        <tr>
                                            <td>
                                                <strong>{{ $post->title }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($post->excerpt, 50) }}</small>
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
                                            <td>{{ $post->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    @if($post->is_published)
                                                        <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-secondary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
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
