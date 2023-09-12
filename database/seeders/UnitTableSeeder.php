<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() 
    {
        Unit::insert([
            ['title' => 'Kg'],
            ['title' => 'Pcs'],
            ['title' => ' Grm'],
            ['title' => 'Each'],
            ['title' => 'Box'],
            ['title' => 'Dozen'],
            ['title' => 'Rim'],
            ['title' => 'Ton'],
            ['title' => 'SQF'],
            ['title' => 'Tube'],
            ['title' => 'Pot'],
            ['title' => 'Bundle'],
            ['title' => 'Day'],
            ['title' => 'Pound'],
            ['title' => 'Jar'],
            ['title' => 'Bottle'],
            ['title' => 'Lot'],
            ['title' => 'Ltr'],
            ['title' => 'Yard'],
            ['title' => 'RFT'],
            ['title' => 'Time'],
            ['title' => 'ml'],
            ['title' => 'Truck'],
            ['title' => 'Cum'],
            ['title' => 'Packet'],
            ['title' => 'Reel'],
            ['title' => 'Booklet'],
            ['title' => 'RM'],
            ['title' => 'Sqm'],
            ['title' => 'Goj'],
            ['title' => 'Carton'],
            ['title' => 'Gram'],
            ['title' => 'Tools'],
            ['title' => 'BOOK'],
            ['title' => 'Job'],
            ['title' => 'Meter'],
            ['title' => 'Pair'],
            ['title' => 'Feet'],
            ['title' => 'Gallon'],
            ['title' => 'Set'],
            ['title' => 'Cylinder'],
            ['title' => 'Bag'],
            ['title' => 'Can'],
            ['title' => 'CFT'],
            ['title' => 'Coil'],
            ['title' => 'Kilogram'],
        ]);
    }
}
