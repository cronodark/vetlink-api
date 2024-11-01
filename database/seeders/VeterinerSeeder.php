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
                    'https://cdn.discordapp.com/attachments/855482040333762590/1300381651066552380/img_rspets.png?ex=672496c9&is=67234549&hm=728646c13a08e43a47995fecf6e86c96a3f21391ec220bf1037ce485c110772d&',
                    'https://cdn.discordapp.com/attachments/855482040333762590/1300382137555488859/Foto-3-1-scaled.png?ex=6724973d&is=672345bd&hm=f21f140cb84f1ed9840db9701dd02fb0480efba923bd96604cb421218d3b4a27&'
                ]),
                'longitude' => $faker->randomFloat(2, 100.0, 110.0),
                'latitude' => $faker->randomFloat(2, -10.0, -5.0),
                'address' => $faker->address(),
                'document' => "file.docx",
                'city' => $faker->city(),
                'open_time' => $faker->time($format = 'H:i', $max = '08:00'), // e.g., generates a time up to 8:00 AM
                'close_time' => $faker->time($format = 'H:i', $max = '17:00'), // e.g., generates a time up to 5:00 PM
            ]);
        }
    }
}
