<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\Category;
use App\Models\MadeIn;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AuctionProduct>
 */
class AuctionProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'auction_id' => Auction::inRandomOrder()->first(),
            'catalogue_id' => Catalogue::inRandomOrder()->first(),
            'title' => $this->faker->sentence(),
            'brand_id' => Brand::inRandomOrder()->first(),
            'made_in' => MadeIn::inRandomOrder()->first(),
            'unit_id' => Unit::inRandomOrder()->first(),
            'quantity' => $this->faker->numberBetween(1,100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
