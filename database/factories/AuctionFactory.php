<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auction>
 */
class AuctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title =  $this->faker->sentence();
        return [
            'user_id' => User::inRandomOrder()->first(),
            'service_type' => $this->faker->numberBetween(1,3),
            'is_open_bid' => $this->faker->numberBetween(0,1),
            'title' => $this->faker->sentence(),
            'slug' => Str::slug($title),
            'description' => $this->getDescription(),
            'delivery_address' => $this->faker->numberBetween(0,1),
            'lat' => $this->faker->latitude(),
            'long' => $this->faker->longitude(),
            'start_time' => $this->faker->dateTime(),
            'end_time' => $this->faker->dateTime(),
            'included_delivery_cost' => $this->faker->numberBetween(0,1),
            'delivery_date' => $this->faker->date(),
            'comment' => $this->faker->text()
        ];
    }

    function getDescription() {
        $paragraphs = $this->faker->paragraphs(rand(2, 20));
        $title = $this->faker->realText(50);
        $post = "<h3>{$title}</h3><br>";
        foreach ($paragraphs as $para) {
            $post .= "<p>{$para}</p>";
        }

        return $post;
    }
}
