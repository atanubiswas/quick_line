<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\order_test;

class orderTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $faker = Faker::create();

        // Generate orders
        for ($i = 0; $i < 300; $i++) {
            $orderTest = new order_test;
            $orderTest->order_id = $faker->numberBetween(1, 100);
            $orderTest->pathology_test_id = $faker->numberBetween(1, 4);
            $orderTest->created_at = now();
            $orderTest->updated_at = now();
            $orderTest->save();
        }
    }
}
