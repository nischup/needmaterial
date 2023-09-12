<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::insert([
            ['title' => 'LG'],
            ['title' => 'Sony'],
            ['title' => 'Walton'],
            ['title' => 'HB'],
            ['title' => 'ASUS'],
            ['title' => 'Apex'],
            ['title' => 'Hatil'],
            ['title' => 'Gazi'],
            ['title' => 'Japan'],
            ['title' => 'Bellissimo'],
            ['title' => 'Lovibond'],
            ['title' => 'RFL'],
            ['title' => 'SKF'],
            ['title' => 'BBS'],
            ['title' => 'BSRM'],
            ['title' => 'Aman'],
            ['title' => 'Tenda'],
            ['title' => 'Samsung'],
            ['title' => 'Berger'],
            ['title' => 'Silver'],
        ]);
    }
}
