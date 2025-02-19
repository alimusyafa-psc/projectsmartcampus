<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'admin',
    ],

    /*
     * Authentication Guards
     *
     * Supported: "session", "token"
     */

    'session' => [
        'connection' => 'mysql_third',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'admin',

        ],
    ],

    /*
     * User Providers
     *
     * Supported: "database", "eloquent"
     */

    'providers' => [
        'admin' => [
            'driver' => 'eloquent',
            'model' => App\Models\LoginUser::class,
            'table' => 'admin',
            'connection' => 'mysql_third',
        ],
    ],

    /*
     * Resetting Passwords
     *
     * Expire time in minutes
     */

    'passwords' => [
        'admin' => [
            'provider' => 'admin',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
     * Password Confirmation Timeout
     *
     * Time in seconds before a password confirmation times out
     */

    'password_timeout' => 10800,

];
