<?php

namespace Database\Factories;

use App\Models\Catalogue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CatalogueImage>
 */
class CatalogueImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'catalogue_id' => Catalogue::inRandomOrder()->first(),
            'src' => null,
        ];
    }
}
