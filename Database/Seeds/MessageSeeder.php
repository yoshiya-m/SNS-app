<?php

namespace Database\Seeds;

use Database\Seeder;
use Faker\Factory as Faker;
use Models\Message;

class MessageSeeder implements Seeder
{

    public function seed(): void
    {

        $rows = self::createRowData();
        foreach ($rows as $row) {
            Message::create($row);
        }
    }

    public function createRowData(): array
    {
        $num = 10;
        for ($i = 0; $i < $num; $i++) {
            $faker = Faker::create();
            $rows[] = [
                'message_id' => null,
                'encrypted_content'          => $faker->sentence(),
                'sender_id'         => random_int(31, 52),
                'receiver_id'         => random_int(31, 52),
            ];
        }
        return $rows;
    }
}
