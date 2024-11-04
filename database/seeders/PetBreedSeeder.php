<?php

namespace Database\Seeders;

use App\Models\PetBreed;
use App\Models\PetType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetBreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $anjing = PetType::where('name', 'Anjing')->first();
        $kucing = PetType::where('name', 'Kucing')->first();
        $kelinci = PetType::where('name', 'Kelinci')->first();

        // Add breeds for Anjing
        PetBreed::create(['breed_name' => 'Golden Retriever', 'pet_type_id' => $anjing->id]);
        PetBreed::create(['breed_name' => 'Bulldog', 'pet_type_id' => $anjing->id]);
        PetBreed::create(['breed_name' => 'Poodle', 'pet_type_id' => $anjing->id]);

        // Add breeds for Kucing
        PetBreed::create(['breed_name' => 'Persian', 'pet_type_id' => $kucing->id]);
        PetBreed::create(['breed_name' => 'Siamese', 'pet_type_id' => $kucing->id]);
        PetBreed::create(['breed_name' => 'Bengal', 'pet_type_id' => $kucing->id]);

        // Add breeds for Kelinci
        PetBreed::create(['breed_name' => 'Holland Lop', 'pet_type_id' => $kelinci->id]);
        PetBreed::create(['breed_name' => 'Netherland Dwarf', 'pet_type_id' => $kelinci->id]);
        PetBreed::create(['breed_name' => 'Flemish Giant', 'pet_type_id' => $kelinci->id]);


    }
}
