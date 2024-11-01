<?php

return [
    'global'=>[
        \Middleware\HttpLoggingMiddleware::class,
        \Middleware\SessionsSetupMiddleware::class,
    ],
    'aliases'=>[
        'auth'=>\Middleware\AuthenticatedMiddleware::class,
        'guest'=>\Middleware\GuestMiddleware::class,
        'signature'=>\Middleware\SignatureValidationMiddleware::class,
    ]
];