<?php

namespace Database\Seeders;

use App\Models\ForumComment;
use App\Models\ForumPost;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Pest\Laravel\get;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate comments for forum posts
        $forumPostIds = ForumPost::pluck('id')->toArray();
        $userIds = User::where('role', 'customer')->pluck('id')->toArray();

        $faker = Factory::create('id_ID');

        foreach ($forumPostIds as $forumPostId) {
            for($i = 0; $i < 10; $i++){
                ForumComment::create([
                    'content' => $faker->text(100),
                    'forum_post_id' => $forumPostId,
                    'user_id' => $faker->randomElement($userIds)
                ]);
            }
        }
    }
}
