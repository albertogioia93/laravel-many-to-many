<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        Post::truncate();

        for($i = 0; $i < 10; $i++){


            $type = Type::inRandomOrder()->first(); //1 record della tabella types -> 1 istanza

            $post = new Post();
            $post->title = $faker->sentence(3);
            $post->content = $faker->text(500);
            $post->slug = Str::slug($post->title, '-');
            $post->type_id = $type->id;
            $post->save();
        }
    }
}
