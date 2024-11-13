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
        // Fetch 10 random veteriner user IDs
        $veterinersId = User::where('role', 'veteriner')->pluck('id')->shuffle()->take(7)->toArray();

        $faker = Factory::create('id_ID');

        // Define clinics with the provided names, latitude, and longitude
        $clinics = [
            [
                'name' => 'Klinik Hewan IPB Taman Kencana',
                'latitude' => '-6.587519358805901',
                'longitude' => '106.8012401475101',
                'city' => 'Bogor'
            ],
            [
                'name' => 'Klinik Hewan Satwagia',
                'latitude' => '-6.58701111013912',
                'longitude' => '106.77220795869333',
                'city' => 'Bogor'
            ],
            [
                'name' => 'Klinik Hewan Kendari',
                'latitude' => '-4.011817962854218',
                'longitude' => '122.53009057452483',
                'city' => 'Bogor'
            ],
            [
                'name' => 'Stella Pet Clinic',
                'latitude' => '-6.58071217233057',
                'longitude' => '106.80837389473207',
                'city' => 'Bogor'
            ],
            [
                'name' => 'Myma Pet House',
                'latitude' => '-6.56385214027301',
                'longitude' => '106.78540340521744',
                'city' => 'Bogor'
            ],
            [
                'name' => 'Depok Petshop & Vet',
                'latitude' => '-6.390547223632163',
                'longitude' => '106.84038668207796',
                'city' => 'Depok'
            ],
            [
                'name' => 'Vetpet 2 Animal Clinic',
                'latitude' => '-6.402272505706233',
                'longitude' => '106.84254498622941',
                'city' => 'Depok'
            ],
        ];

        // Iterate over the clinic data to create veteriner records
        foreach ($clinics as $index => $clinic) {
            // Ensure that we have enough veteriner IDs
            if (!isset($veterinersId[$index])) {
                break; // Break if there are no more available veteriner IDs
            }

            $userId = $veterinersId[$index];

            Veteriner::create([
                'id_user' => $userId,
                'clinic_name' => $clinic['name'],
                'register_status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'clinic_image' => $faker->randomElement([
                    'https://asset-2.tstatic.net/wartakota/foto/bank/images/20140722-rumah-sakit-rs.jpg',
                    'https://upload.wikimedia.org/wikipedia/id/f/f4/RS_Hewan_UB.png'
                ]),
                'longitude' => $clinic['longitude'],
                'latitude' => $clinic['latitude'],
                'address' => $faker->address(),
                'document' => "file.docx",
                'city' => $clinic['city'],
                'open_time' => $faker->time($format = 'H:i', $max = '08:00'), // Generates a time up to 8:00 AM
                'close_time' => $faker->time($format = 'H:i', $max = '17:00'), // Generates a time up to 5:00 PM
            ]);
        }
    }
}
