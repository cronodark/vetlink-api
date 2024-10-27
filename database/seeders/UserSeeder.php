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

        // Create users
        $veterinerEmails = ['veteriner@gmail.com', 'veteriner2@gmail.com', 'veteriner3@gmail.com'];

        foreach ($veterinerEmails as $email) {
            User::factory()->create([
                'name' => $faker->name(),
                'email' => $email,
                'username' => str_replace('@gmail.com', '', $email),
                'role' => 'veteriner',
                'photo' => null,
                'phone' => $faker->phoneNumber(),
                'password' => bcrypt('123'),
            ]);
        }

    }
}
