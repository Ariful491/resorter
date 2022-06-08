<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('users')->insert(
            [
                "name"=>"admin",
                "email"=>"admin@gmail.com",
                "email_verified_at"=>"2022-06-08 19:35:07",
                "password"=>Hash::make('12345678')
            ]
        );

    }
}
