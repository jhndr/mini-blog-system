@extends('admin.layout')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stats Cards -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-file-alt text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $stats['total_posts'] }}</h3>
                <p class="text-gray-600">Total Posts</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $stats['pending_posts'] }}</h3>
                <p class="text-gray-600">Pending Posts</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $stats['approved_posts'] }}</h3>
                <p class="text-gray-600">Approved Posts</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-times text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $stats['declined_posts'] }}</h3>
                <p class="text-gray-600">Declined Posts</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Pending Posts -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Posts Awaiting Moderation</h3>
        </div>
        <div class="p-6">
            @if($pending_posts->count() > 0)
                <div class="space-y-4">
                    @foreach($pending_posts as $post)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg" 
                             x-data="{ showModal: false }">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $post->title }}</h4>
                                <p class="text-sm text-gray-600">
                                    by {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <button @click="approvePost({{ $post->id }})"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                    <i class="fas fa-check mr-1"></i>
                                    Approve
                                </button>
                                <button @click="showModal = true"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                    <i class="fas fa-times mr-1"></i>
                                    Decline
                                </button>
                            </div>

                            <!-- Decline Confirmation Modal -->
                            <div x-show="showModal" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                                 @click="showModal = false">
                                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
                                     @click.stop>
                                    <div class="mt-3 text-center">
                                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mt-2">Decline Post</h3>
                                        <div class="mt-2 px-7 py-3">
                                            <p class="text-sm text-gray-500">
                                                Are you sure you want to decline "{{ $post->title }}"? This action cannot be undone.
                                            </p>
                                        </div>
                                        <div class="flex justify-center space-x-4 mt-4">
                                            <button @click="showModal = false"
                                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                                Cancel
                                            </button>
                                            <button @click="declinePost({{ $post->id }}); showModal = false"
                                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                                Decline
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.posts.index', ['status' => 'pending']) }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm">
                        View all pending posts →
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No posts awaiting moderation.</p>
            @endif
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recent Posts</h3>
        </div>
        <div class="p-6">
            @if($recent_posts->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_posts->take(5) as $post)
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $post->title }}</h4>
                                <p class="text-sm text-gray-600">
                                    by {{ $post->user->name }} • 
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                        {{ $post->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $post->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $post->status === 'declined' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.posts.index') }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm">
                        View all posts →
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No posts found.</p>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function approvePost(postId) {
        fetch(`/admin/posts/${postId}/approve`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    function declinePost(postId) {
        fetch(`/admin/posts/${postId}/decline`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
</script>
@endpush
