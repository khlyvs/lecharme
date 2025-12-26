<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Subcategory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $nameAz = $this->faker->unique()->words(3, true);
        $nameEn = $this->faker->unique()->words(3, true);
        $nameRu = $this->faker->unique()->words(3, true);

        $category = Category::inRandomOrder()->first();
        $subcategory = $category?->subcategories()->inRandomOrder()->first();

        return [
            'category_id'    => 1,
            'subcategory_id' => 1,

            'name_az' => ucfirst($nameAz),
            'name_en' => ucfirst($nameEn),
            'name_ru' => ucfirst($nameRu),

            'slug_az' => Str::slug($nameAz),
            'slug_en' => Str::slug($nameEn),
            'slug_ru' => Str::slug($nameRu),

            'description_az' => $this->faker->sentence(10),
            'description_en' => $this->faker->sentence(10),
            'description_ru' => $this->faker->sentence(10),

            'price' => $this->faker->numberBetween(10, 500),
            'is_active' => true,
        ];
    }
}
