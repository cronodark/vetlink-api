<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Factory::create('id_ID');

        User::factory()->create([
            'name' => $faker->name(),
            'email' => 'admin@vetlink.com',
            'username' => 'admin',
            'role' => 'admin',
            'photo' => null,
            'phone' => $faker->phoneNumber(),
            'password' => bcrypt('123'),
        ]);

        User::factory()->create([
            'name' => $faker->name(),
            'email' => 'customer@gmail.com',
            'username' => 'customer',
            'role' => 'customer',
            'photo' => null,
            'phone' => $faker->phoneNumber(),
            'password' => bcrypt('123'),
        ]);

        User::factory()->create([
            'name' => $faker->name(),
            'email' => 'customer1@gmail.com',
            'username' => 'customer1',
            'role' => 'customer',
            'photo' => null,
            'phone' => $faker->phoneNumber(),
            'password' => bcrypt('123'),
        ]);

        User::factory()->create([
            'name' => $faker->name(),
            'email' => 'veteriner@gmail.com',
            'username' => 'veteriner',
            'role' => 'veteriner',
            'photo' => null,
            'phone' => $faker->phoneNumber(),
            'password' => bcrypt('123'),
        ]);

    }
}
