<?php

use Illuminate\Database\Seeder;

class FavouritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Favourite::class, 1000)->create();
//        factory(App\User::class, 50)->create()->each(function($u) {
//            $u->favourites()->save(factory(App\Favourite::class)->make());
//        });
    }
}
