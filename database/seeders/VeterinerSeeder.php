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

        $veterinersId = User::where('role', 'veteriner')->pluck('id')->toArray();

        $faker = Factory::create('id_ID');

        Veteriner::create([
            'id_user' => $faker->randomElement($veterinersId),
            'clinic_name' => 'hewan kasih',
            'register_status' => false,
            'longitude' => $faker->randomFloat(2, 0, 50),
            'latitude' => $faker->randomFloat(2, 0, 50),
            'address' => $faker->address(),
            'document' => "file.docx"
        ]);

    }
}
