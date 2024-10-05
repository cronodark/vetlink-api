<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customerIds = User::where('role', 'customer')->pluck('id')->toArray();
        $faker = Factory::create('id_ID');

        for ($i = 0; $i < 5; $i++) {
            Pet::create([
                'pet_name' => $faker->name,
                'type' => $faker->randomElement(['Kucing', 'Anjing', 'Kelinci']),
                'age' => $faker->randomNumber(),
                'weight' => $faker->randomFloat(1, 1, 30),
                'id_user' => $faker->randomElement($customerIds)
            ]);
        }

    }
}
