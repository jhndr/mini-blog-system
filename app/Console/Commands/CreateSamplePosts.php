<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class CreateSamplePosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:create-samples';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create sample posts for testing admin moderation';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Creating sample posts...');

        // Get or create a regular user
        $user = User::whereDoesntHave('roles')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'John Doe',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
            $this->info('Created regular user: user@example.com');
        }

        // Get a category
        $category = Category::first();
        if (!$category) {
            $category = Category::create([
                'name' => 'General',
                'slug' => 'general',
                'description' => 'General posts'
            ]);
        }

        // Sample posts data
        $samplePosts = [
            [
                'title' => 'Understanding Laravel Middleware',
                'content' => 'Laravel middleware provides a convenient mechanism for filtering HTTP requests entering your application. In this post, we\'ll explore how to create and use middleware effectively.',
                'status' => 'pending'
            ],
            [
                'title' => 'Getting Started with Vue.js Components',
                'content' => 'Vue.js components are reusable Vue instances with a name. They accept the same options as new Vue, such as data, computed, watch, methods, and lifecycle hooks.',
                'status' => 'pending'
            ],
            [
                'title' => 'Database Optimization Techniques',
                'content' => 'Optimizing database performance is crucial for web applications. This article covers indexing strategies, query optimization, and database design best practices.',
                'status' => 'pending'
            ],
            [
                'title' => 'CSS Grid vs Flexbox: When to Use Which',
                'content' => 'Both CSS Grid and Flexbox are powerful layout systems, but they serve different purposes. Learn when to use each one for optimal results.',
                'status' => 'approved'
            ],
            [
                'title' => 'Introduction to API Design',
                'content' => 'Designing effective APIs is an art. This post covers REST principles, proper HTTP status codes, and best practices for API documentation.',
                'status' => 'pending'
            ]
        ];

        $created = 0;
        foreach ($samplePosts as $postData) {
            $existingPost = Post::where('title', $postData['title'])->first();
            if (!$existingPost) {
                Post::create([
                    'title' => $postData['title'],
                    'slug' => \Str::slug($postData['title']),
                    'content' => $postData['content'],
                    'excerpt' => \Str::limit($postData['content'], 100),
                    'status' => $postData['status'],
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'published_at' => $postData['status'] === 'approved' ? now() : null,
                ]);
                $created++;
            }
        }

        $this->info("Created {$created} sample posts successfully!");
        $this->info('You can now test the admin moderation functionality.');
        
        return Command::SUCCESS;
    }
}
