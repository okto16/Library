<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i=0;$i<20;$i++) {
            $user = new User;
            $user->name = $faker->name;
            $user->email = $faker->email;
            $user->password = $faker->password;
            $user->member_id = rand(1,20);
            $user->save();
        }
    }
}
