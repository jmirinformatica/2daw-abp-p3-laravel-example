<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        $nPosts = rand(4,8);
        $posts = Post::factory($nPosts)->create([
            'author_id' => $user->id,
        ]);

        foreach($posts as $post) {
            $nComments = rand(0,4);
            for($i=0; $i<$nComments; $i++) {
                Comment::factory()->create([
                    'post_id' => $post->id,
                ]);
            }    
        }
    }
}
