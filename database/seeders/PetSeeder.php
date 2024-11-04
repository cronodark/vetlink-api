<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\PetBreed;
use App\Models\PetType;
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

        $petTypes = PetType::with('breeds')->get();

        for ($i = 0; $i < 10; $i++) {
            // Randomly select a PetType
            $petType = $petTypes->random();

            // Get a breed that is associated with the selected type
            $breed = $petType->breeds->random();

            Pet::create([
                'pet_name' => $faker->randomElement(['Bella', 'Charlie', 'Luna', 'Max', 'Oliver', 'Simba', 'Chloe', 'Milo']),
                'type' => $petType->id, // Set type ID from the selected PetType
                'breed' => $breed->id, // Set breed ID from the selected PetBreed
                'photo' => $faker->imageUrl(640, 480, 'animals', true),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'age' => $faker->numberBetween(1, 9),
                'notes' => $faker->randomElement(['','Lorem ipsum dolor sit amet']),
                'weight' => $faker->randomFloat(1, 1, 30),
                'id_user' => $faker->randomElement($customerIds)
            ]);
        }

    }
}
