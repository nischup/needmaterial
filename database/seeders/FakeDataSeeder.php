<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\AuctionProduct;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\CatalogueImage;
use App\Models\Company;
use App\Models\MadeIn;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::findOrCreate('customer');

        Role::findOrCreate('supplier');

        User::factory(50)->create()->each(function ($user) {
            $user->assignRole('customer');
        });

        User::factory(50)->create()->each(function ($user) {
            $user->assignRole('supplier');
        });

//        Brand::factory(20)->create();

        Catalogue::factory()->count(100)->has(
            CatalogueImage::factory()->count(10), 'images'
        )->create();

        Company::factory(50)->create();

        MadeIn::factory(50)->create();

        $auctions = Auction::factory(200)->create();

        foreach ($auctions as $auction) {
            $array = [];
            $ids = Catalogue::inRandomOrder()->limit(rand(1,10))->pluck('id')->toArray();
            foreach ($ids as $id) {
                $array[] = [
                    'auction_id' => $auction->id,
                    'catalogue_id' => $id,
                    'brand_id' => Brand::inRandomOrder()->first()->id,
                    'unit_id' => Unit::inRandomOrder()->first()->id,
                    'made_in' => MadeIn::inRandomOrder()->first()->id,
                    'quantity' => rand(1,100),
                ];
            }

            AuctionProduct::insert($array);
        }
    }
}
