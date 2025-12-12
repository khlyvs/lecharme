<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // 10 category + onların subcategory-ləri
        Category::factory()->count(10)->create();
    }
}
