<?php

namespace Database\Seeders;

use App\Models\PetType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        PetType::create([
            'name' => 'Kucing'
        ]);
        PetType::create([
            'name' => 'Anjing'
        ]);
        PetType::create([
            'name' => 'Kelinci'
        ]);
    }
}
