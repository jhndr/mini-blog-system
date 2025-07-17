<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Technology', 'description' => 'Latest tech news and tutorials'],
            ['name' => 'Travel', 'description' => 'Travel guides and experiences'],
            ['name' => 'Food', 'description' => 'Recipes and food reviews'],
            ['name' => 'Lifestyle', 'description' => 'Life tips and experiences'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}