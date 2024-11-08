<?php

namespace Database\Seeders;

use App\Models\Pet;
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

            $pets = Pet::where('id_user', $customerIds)->get();
            $petId = $pets->isNotEmpty() ? $pets->random()->id : null;

            Queue::create([
                'appointment_time' => $faker->dateTimeBetween('now', '+2 weeks'),
                'status' => $faker->randomElement(['pending', 'ongoing', 'finished']),
                'id_customer' => $faker->randomElement($customerIds),
                'id_veteriner' => $faker->randomElement($veterinerIds),
                'id_pet' => $petId,
            ]);
        }


    }
}
