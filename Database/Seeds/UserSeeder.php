<?php

namespace Database\Seeds;




use Database\Seeder;
use Faker\Factory as Faker;
use Models\User;

class UserSeeder implements Seeder
{

    public function seed(): void
    {

        $rows = self::createRowData();
        foreach ($rows as $row) {
            User::create($row);
        }
    }

    public function createRowData(): array
    {
        $num = 10;
        for ($i = 0; $i < $num; $i++) {
            $faker = Faker::create();
            $rows[] = [
                'user_id' => null,
                'user_name'          => $faker->word(),
                'bio'         => $faker->sentence(),
                'encrypted_email'         => $faker->word(),
                'hashed_password'         => $faker->word(),
                'created_at'     => null,
                'updated_at'   => null,
            ];
        }
        return $rows;
    }
}
