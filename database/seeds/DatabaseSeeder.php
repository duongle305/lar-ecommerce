<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(ProvincesTableSeeder::class);
         $this->call(DistrictsTableSeeder::class);
         $this->call(WardsTableSeeder::class);
         $this->call(WardsTableSeeder2::class);
         $this->call(OrderStatusTableSeeder::class);
    }
}
