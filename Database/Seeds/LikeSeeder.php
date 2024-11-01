<?php

namespace Database\Seeds;

use Database\Seeder;
use Models\Like;

class LikeSeeder implements Seeder
{

    public function seed(): void
    {

        $rows = self::createRowData();
        foreach ($rows as $row) {
            Like::create($row);
        }
    }

    public function createRowData(): array
    {
        $num = 10;
        for ($i = 0; $i < $num; $i++) {
            $rows[] = [
                'like_id' => null,
                'user_id'          => random_int(31, 52),
                'post_id'         => random_int(1, 10),
            ];
        }
        return $rows;
    }
}
