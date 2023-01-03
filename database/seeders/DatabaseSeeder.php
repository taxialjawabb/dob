<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     *      php artisan db:seed

     * 
     * @return void
     */
    public function run()
    {
        //  \App\Models\Admin::factory(10)->create(

        //  );
        $this->call([
            AdminSeeder::class,
            CatogreySeeder::class,
            VechileSeeder::class,
            DriverSeeder::class,
            RiderSeeder::class,
            TripSeeder::class,
         ]);
    }
}
