<?php


require '../vendor/autoload.php';
spl_autoload_extensions(".php");
spl_autoload_register(function ($class) {
    $filePath = __DIR__ . "/../" . str_replace("\\", "/", $class) . ".php";
    if (file_exists($filePath)) {
        require_once($filePath);
    }
});

// シードしたいクラス
$seeds = [
    // \Database\Seeds\UserSeeder::class,
    // \Database\Seeds\PostSeeder::class,
    // \Database\Seeds\ScheduledPostSeeder::class,
    // \Database\Seeds\MessageSeeder::class,
    // \Database\Seeds\FollowSeeder::class,
    // \Database\Seeds\LikeSeeder::class,
    // \Database\Seeds\NotificationSeeder::class,
];


foreach($seeds as $seed) {
    $seeder = new $seed();
    $seeder->seed();
}