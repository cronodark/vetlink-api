<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Veteriner;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VeterinerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $veterinersId = User::where('role', 'veteriner')->pluck('id')->shuffle()->take(10)->toArray();

        $faker = Factory::create('id_ID');

        $clinics = [
            'Paw Care Veterinary',
            'Sahabat Hewan Sejati',
            'PetPedia Clinic',
            'Healing Paws',
            'Tunas Hewan Terbaik',
            'Love Tails Vet',
            'Hati Hewan',
            'Sentra Satwa Care',
            'Klinik Sahabat Berbulu',
            'Pets and Friends Clinic'
        ];

        foreach ($clinics as $index => $clinicName) {
            // Select a user ID from the randomized and limited veteriner list
            $userId = $veterinersId[$index];

            Veteriner::create([
                'id_user' => $userId,
                'clinic_name' => $clinicName,
                'register_status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'clinic_image' => $faker->randomElement([
                    'https://cdn.discordapp.com/attachments/855482040333762590/1300381651066552380/img_rspets.png?ex=6720a249&is=671f50c9&hm=07a6e975d96d7b0c85018de4f92a2cb6f744c5c298a7de794ef8a7468dba7106&',
                    'https://cdn.discordapp.com/attachments/855482040333762590/1300382137555488859/Foto-3-1-scaled.png?ex=6720a2bd&is=671f513d&hm=c812ec1a0af47e8d2703ef554fcf8ae3789be11402d9c01ecf13251128cb8a30&'
                ]),
                'longitude' => $faker->randomFloat(2, 100.0, 110.0),
                'latitude' => $faker->randomFloat(2, -10.0, -5.0),
                'address' => $faker->address(),
                'document' => "file.docx"
            ]);
        }
    }
}
