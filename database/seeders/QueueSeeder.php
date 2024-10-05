<?php

namespace Database\Seeders;

use App\Models\Queue;
use App\Models\User;
use App\Models\Veteriner;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        $customerIds = User::where('role', 'customer')->pluck('id')->toArray();
        $veterinerIds = Veteriner::pluck('id')->toArray();

        for($i = 0; $i < 10; $i++) {
            Queue::create([
                'appointment_time' => $faker->dateTimeBetween('now', '+2 weeks'),
                'status' => $faker->randomElement(['pending', 'ongoing', 'finished']),
                'id_customer' => $faker->randomElement($customerIds),
                'id_veteriner' => $faker->randomElement($veterinerIds),
            ]);
        }


    }
}
