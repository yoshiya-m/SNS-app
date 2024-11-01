<?php

namespace Database\Seeds;

use Database\Seeder;
use Faker\Factory as Faker;
use Models\ScheduledPost;

class ScheduledPostSeeder implements Seeder
{

    public function seed(): void
    {

        $rows = self::createRowData();
        foreach ($rows as $row) {
            ScheduledPost::create($row);
        }
    }

    public function createRowData(): array
    {
        $num = 10;
        for ($i = 0; $i < $num; $i++) {
            $faker = Faker::create();
            $rows[] = [
                'scheduled_post_id' => null,
                'content'          => $faker->sentence(),
                'user_id'         => random_int(31, 52),
                'scheduled_time'         => date('Y-m-d H:i:s'),
            ];
        }
        return $rows;
    }
}
