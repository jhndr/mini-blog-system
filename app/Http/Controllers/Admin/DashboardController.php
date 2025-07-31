<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:view admin dashboard']);
    }

    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'pending_posts' => Post::pending()->count(),
            'approved_posts' => Post::approved()->count(),
            'declined_posts' => Post::declined()->count(),
            'total_users' => User::count(),
            'total_categories' => Category::count(),
        ];

        $recent_posts = Post::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $pending_posts = Post::with(['user', 'category'])
            ->pending()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_posts', 'pending_posts'));
    }
}
