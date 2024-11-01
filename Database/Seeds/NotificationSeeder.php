<?php

namespace Database\Seeds;

use Database\Seeder;
use Models\Notification;

class NotificationSeeder implements Seeder
{

    public function seed(): void
    {

        $rows = self::createRowData();
        foreach ($rows as $row) {
            Notification::create($row);
        }
    }

    public function createRowData(): array
    {
        $num = 10;
        for ($i = 0; $i < $num; $i++) {
            $rows[] = [
                'notification_id' => null,
                'notification_type'          => 'like',
                'user_id'         => random_int(31, 52),
                'like_id'         => random_int(3, 12),
                'follower_id'         => null,
                'message_id'         => null,
                'has_read'         => false,
            ];
        }
        return $rows;
    }
}
