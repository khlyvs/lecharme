<?php

namespace Database\Factories;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubcategoryFactory extends Factory
{
    protected $model = Subcategory::class;

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
}
