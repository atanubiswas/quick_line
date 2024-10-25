<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\order;

class orderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Generate orders
        for ($i = 0; $i < 100; $i++) {
            $order = new order();
            $order->patient_id = $faker->numberBetween(1, 100);
            $order->laboratorie_id = $faker->numberBetween(8, 13);
            $order->order_number = 'O-'.$faker->unique()->uuid;
            $order->description = $faker->text;
            $order->total_amount = $faker->randomFloat(2, 50, 500);
            $order->discounted_amount = $faker->randomFloat(2, 0, $order->total_amount);
            $order->payable_amount = $order->total_amount - $order->discounted_amount;
            $order->status = $faker->randomElement(['pending', 'processing', 'pickup', 'submitted_to_lab', 'testing', 'completed', 'cancelled']);
            $order->ordered_at = $faker->dateTimeThisMonth;
            $order->processed_at = $faker->dateTimeThisMonth;
            $order->completed_at = $faker->dateTimeThisMonth;
            $order->save();
        }
    }
}
