<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the public home page with latest posts.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::with(['user', 'category'])
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(6);
            
        $categories = Category::withCount('posts')->get();
        
        return view('home', compact('posts', 'categories'));
    }

    /**
     * Show the application dashboard (requires auth).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $user = auth()->user();
        $totalPosts = Post::where('user_id', $user->id)->count();
        $publishedPosts = Post::where('user_id', $user->id)
            ->where('is_published', true)
            ->count();
        $draftPosts = Post::where('user_id', $user->id)
            ->where('is_published', false)
            ->count();
            
        $posts = Post::with(['category'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $categories = Category::all();
            
        return view('dashboard', compact('totalPosts', 'publishedPosts', 'draftPosts', 'posts', 'categories'));
    }
}
