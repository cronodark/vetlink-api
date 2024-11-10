<?php

namespace Database\Seeders;

use App\Models\ForumPost;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForumPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        $customerIds = User::where('role', 'customer')->pluck('id')->toArray();

        for($i = 0; $i < 20; $i++){
            ForumPost::create([
                'title' => $faker->sentence(5),
                'last_seen' => $faker->city(),
                'status' => $faker->randomElement(['lost', 'found']),
                'characteristics' => $faker->text(30),
                'description' => $faker->paragraph(5),
                'id_user' => $faker->randomElement($customerIds),
                'pet_image' => $faker->imageUrl(640, 480, 'cats'),
            ]);
        }
    }
}
