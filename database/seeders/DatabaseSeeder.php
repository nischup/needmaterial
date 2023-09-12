<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create a initial admin account
         User::create([
             'name' => 'Admin',
             'email' => 'admin@mail.com',
             'phone' => '123456789',
             'password' => bcrypt('password')
         ]);

         User::create([
             'name' => 'Customer',
             'email' => 'customer@mail.com',
             'phone' => '123456780',
             'password' => bcrypt('password')
         ]);

         User::create([
             'name' => 'Supplier',
             'email' => 'supplier@mail.com',
             'phone' => '123456785',
             'password' => bcrypt('password')
         ]);

         // Call other seeder classes
        $this->call([
            ACLDataSeeder::class,
            LocationsDataSeeder::class,
            CategoryTableSeeder::class,
            UnitTableSeeder::class,
            BrandTableSeeder::class,
            FakeDataSeeder::class,
        ]);
    }
}
