<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostModerationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:moderate posts']);
    }

    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Post::with(['user', 'category'])->orderBy('created_at', 'desc');
        
        switch ($status) {
            case 'pending':
                $query->pending();
                break;
            case 'approved':
                $query->approved();
                break;
            case 'declined':
                $query->declined();
                break;
        }
        
        $posts = $query->paginate(15);
        
        return view('admin.posts.moderation', compact('posts', 'status'));
    }

    public function approve(Post $post)
    {
        $post->update(['status' => Post::STATUS_APPROVED]);
        
        return response()->json([
            'success' => true,
            'message' => 'Post approved successfully!'
        ]);
    }

    public function decline(Post $post)
    {
        $post->update(['status' => Post::STATUS_DECLINED]);
        
        return response()->json([
            'success' => true,
            'message' => 'Post declined successfully!'
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'post_ids' => 'required|array',
            'action' => 'required|in:approve,decline',
        ]);

        $status = $request->action === 'approve' ? Post::STATUS_APPROVED : Post::STATUS_DECLINED;
        
        Post::whereIn('id', $request->post_ids)
            ->update(['status' => $status]);

        return response()->json([
            'success' => true,
            'message' => ucfirst($request->action) . 'd ' . count($request->post_ids) . ' posts successfully!'
        ]);
    }
}
