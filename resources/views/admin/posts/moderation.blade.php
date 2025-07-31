@extends('admin.layout')

@section('page-title', 'Post Moderation')

@section('content')
<div class="bg-white rounded-lg shadow">
    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200" x-data="{ activeTab: '{{ $status }}' }">
        <nav class="-mb-px flex space-x-8 px-6">
            <button @click="activeTab = 'all'; window.location.href = '{{ route('admin.posts.index') }}'"
                    class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors
                           {{ $status === 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                All Posts ({{ $posts->total() }})
            </button>
            <button @click="activeTab = 'pending'; window.location.href = '{{ route('admin.posts.index', ['status' => 'pending']) }}'"
                    class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors
                           {{ $status === 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Pending ({{ \App\Models\Post::pending()->count() }})
            </button>
            <button @click="activeTab = 'approved'; window.location.href = '{{ route('admin.posts.index', ['status' => 'approved']) }}'"
                    class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors
                           {{ $status === 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Approved ({{ \App\Models\Post::approved()->count() }})
            </button>
            <button @click="activeTab = 'declined'; window.location.href = '{{ route('admin.posts.index', ['status' => 'declined']) }}'"
                    class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors
                           {{ $status === 'declined' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Declined ({{ \App\Models\Post::declined()->count() }})
            </button>
        </nav>
    </div>

    <!-- Bulk Actions -->
    @if($posts->count() > 0 && in_array($status, ['pending', 'all']))
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200" 
             x-data="{ selectedPosts: [], showBulkActions: false }"
             x-init="$watch('selectedPosts', value => showBulkActions = value.length > 0)">
            
            <div x-show="showBulkActions" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="flex items-center justify-between">
                <span class="text-sm text-gray-600">
                    <span x-text="selectedPosts.length"></span> posts selected
                </span>
                <div class="flex space-x-2">
                    <button @click="bulkAction('approve')"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm transition-colors">
                        <i class="fas fa-check mr-1"></i>
                        Approve Selected
                    </button>
                    <button @click="bulkAction('decline')"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm transition-colors">
                        <i class="fas fa-times mr-1"></i>
                        Decline Selected
                    </button>
                </div>
            </div>

            <script>
                function bulkAction(action) {
                    const selectedPosts = this.selectedPosts;
                    if (selectedPosts.length === 0) return;

                    fetch('/admin/posts/bulk-action', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            post_ids: selectedPosts,
                            action: action
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
                }
            </script>
        </div>
    @endif

    <!-- Posts List -->
    <div class="divide-y divide-gray-200">
        @if($posts->count() > 0)
            @foreach($posts as $post)
                <div class="p-6 hover:bg-gray-50 transition-colors" 
                     x-data="{ showDeclineModal: false }">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-4 flex-1">
                            @if(in_array($status, ['pending', 'all']))
                                <input type="checkbox" 
                                       x-model="selectedPosts" 
                                       value="{{ $post->id }}"
                                       class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            @endif
                            
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $post->title }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $post->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $post->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $post->status === 'declined' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 mt-1 line-clamp-2">{{ $post->excerpt }}</p>
                                
                                <div class="flex items-center space-x-4 mt-3 text-sm text-gray-500">
                                    <span>
                                        <i class="fas fa-user mr-1"></i>
                                        {{ $post->user->name }}
                                    </span>
                                    <span>
                                        <i class="fas fa-tag mr-1"></i>
                                        {{ $post->category->name }}
                                    </span>
                                    <span>
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $post->created_at->format('M j, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-2 ml-4">
                            @if($post->status === 'pending')
                                <button @click="approvePost({{ $post->id }})"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-sm transition-colors">
                                    <i class="fas fa-check mr-1"></i>
                                    Approve
                                </button>
                                <button @click="showDeclineModal = true"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm transition-colors">
                                    <i class="fas fa-times mr-1"></i>
                                    Decline
                                </button>
                            @elseif($post->status === 'approved')
                                <button @click="showDeclineModal = true"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm transition-colors">
                                    <i class="fas fa-times mr-1"></i>
                                    Decline
                                </button>
                            @elseif($post->status === 'declined')
                                <button @click="approvePost({{ $post->id }})"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-sm transition-colors">
                                    <i class="fas fa-check mr-1"></i>
                                    Approve
                                </button>
                            @endif
                            
                            <a href="{{ route('posts.show', $post) }}" 
                               class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded text-sm transition-colors">
                                <i class="fas fa-eye mr-1"></i>
                                View
                            </a>
                        </div>
                    </div>

                    <!-- Decline Confirmation Modal -->
                    <div x-show="showDeclineModal" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                         @click="showDeclineModal = false">
                        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
                             @click.stop>
                            <div class="mt-3 text-center">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mt-2">Decline Post</h3>
                                <div class="mt-2 px-7 py-3">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to decline "{{ $post->title }}"? This action can be reversed later.
                                    </p>
                                </div>
                                <div class="flex justify-center space-x-4 mt-4">
                                    <button @click="showDeclineModal = false"
                                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                                        Cancel
                                    </button>
                                    <button @click="declinePost({{ $post->id }}); showDeclineModal = false"
                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                        Decline
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="p-12 text-center">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No posts found</h3>
                <p class="text-gray-500">
                    @if($status === 'pending')
                        There are no posts awaiting moderation.
                    @elseif($status === 'approved')
                        There are no approved posts.
                    @elseif($status === 'declined')
                        There are no declined posts.
                    @else
                        There are no posts to display.
                    @endif
                </p>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $posts->appends(request()->query())->links() }}
        </div>
    @endif
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
