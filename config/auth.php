
<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'store_keepers',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'store_keepers',
        ],

        'api' => [
            'driver' => 'jwt',
            'provider' => 'store_keepers',
            'hash' => false,
        ],
    ],

    'providers' => [
        'store_keepers' => [
            'driver' => 'eloquent',
            'model' => App\Models\StoreKeeper::class,
        ],
    ],

    'passwords' => [
        'store_keepers' => [
            'provider' => 'store_keepers',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
