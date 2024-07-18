<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Member;
class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker= Faker::create();
        for ($i=0; $i < 20; $i++) {
            $member = new Member;
            $member->name = $faker->name;
            $member->gender = rand(0, 1) ? 'P' : 'L';
            $member->phone_number ='0812'.$faker->randomNumber(8);
            $member->address = $faker->address;
            $member->email = $faker->email;
            $member->save();
    }
}
}
