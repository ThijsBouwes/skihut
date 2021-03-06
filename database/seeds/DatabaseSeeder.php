<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(EventsSeeder::class);
        $this->call(ProductsSeeder::class);
//        $this->call(StocksSeeder::class);
    }
}
