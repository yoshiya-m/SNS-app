<?php

namespace Database\Seeds;

use Database\Seeder;
use Models\Follow;

class FollowSeeder implements Seeder
{

    public function seed(): void
    {

        $rows = self::createRowData();
        foreach ($rows as $row) {
            Follow::create($row);
        }
    }

    public function createRowData(): array
    {
        $num = 10;
        for ($i = 0; $i < $num; $i++) {
            $rows[] = [
                'follow_id' => null,
                'follower_id'          => random_int(31, 52),
                'followee_id'         => random_int(31, 52),
            ];
        }
        return $rows;
    }
}
