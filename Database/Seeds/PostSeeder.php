<?php

namespace Database\Seeds;

use Database\Seeder;
use Faker\Factory as Faker;
use Models\Post;

class PostSeeder implements Seeder
{

    public function seed(): void
    {

        $rows = self::createRowData();
        foreach ($rows as $row) {
            Post::create($row);
        }
    }

    public function createRowData(): array
    {
        $num = 10;
        for ($i = 0; $i < $num; $i++) {
            $mediaTypes = ["image", "video"];
            $faker = Faker::create();
            $rows[] = [
                'post_id' => null,
                'content'          => $faker->sentence(),
                'media_type'         => $mediaTypes[array_rand($mediaTypes)],
                'media_path'         => $faker->word(),
                'user_id'         => random_int(31, 40),
                'reply_to_user_id'   => null,
            ];
        }
        return $rows;
    }
}
