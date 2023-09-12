<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class CatalogueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->sentence;

        return [
            'parent_category_id' => Category::inRandomOrder()->first(),
            'category_id' => Category::inRandomOrder()->first(),
            'user_id' => User::inRandomOrder()->first(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->text(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
