<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'user', // sesuai dengan provider di bawah
        ],
    ],

    'providers' => [
        'user' => [ // singular, karena tabel kamu bernama "user"
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    'passwords' => [
        'users' => [ // biarkan tetap "users" di sini
            'provider' => 'user', // ini nyambung ke provider di atas
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
