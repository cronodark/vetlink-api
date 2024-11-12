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
                    'https://asset-2.tstatic.net/wartakota/foto/bank/images/20140722-rumah-sakit-rs.jpg',
                    'https://upload.wikimedia.org/wikipedia/id/f/f4/RS_Hewan_UB.png'
                ]),
                'longitude' => "-6.5987029",
                'latitude' => "106.8060503",
                'address' => $faker->address(),
                'document' => "file.docx",
                'city' => $faker->randomElement(["Bogor", "Depok"]),
                'open_time' => $faker->time($format = 'H:i', $max = '08:00'), // e.g., generates a time up to 8:00 AM
                'close_time' => $faker->time($format = 'H:i', $max = '17:00'), // e.g., generates a time up to 5:00 PM
            ]);
        }
    }
}
