<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $name = $this->faker->unique()->word();

        return [
            'is_active' => true,
            'position'  => 1,
            'name_az'   => ucfirst($name).' AZ',
            'name_en'   => ucfirst($name).' EN',
            'name_ru'   => ucfirst($name).' RU',

            'slug_az'   => Str::slug($name.'-az'),
            'slug_en'   => Str::slug($name.'-en'),
            'slug_ru'   => Str::slug($name.'-ru'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Category $category) {
            // Hər Category-ə 3–6 subcategory yaradırıq
            \App\Models\Subcategory::factory()
                ->count(rand(3,6))
                ->create([
                    'category_id' => $category->id,
                ]);
        });
    }
}
