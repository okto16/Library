<?php

namespace Database\Seeders;

use App\Models\TransactionDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TransactionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {

            $detail = new TransactionDetail;
            $detail->transaction_id = $faker->numberBetween(1, 20);
            $detail->book_id = $faker->numberBetween(1, 20);
            $detail->qty = $faker->numberBetween(1, 20);
            $detail->save();
        }
    }
}
