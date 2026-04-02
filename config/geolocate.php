<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Geolocate Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default geolocation driver that will be used
    | to look up IP address information. You may set this to any of the
    | drivers defined in the "drivers" array below.
    |
    */

    'default' => env('GEOLOCATE_DRIVER', 'freeipapi'),

    /*
    |--------------------------------------------------------------------------
    | Geolocate Drivers
    |--------------------------------------------------------------------------
    |
    | Here you may configure the geolocation drivers for your application.
    | Each addon package will register its own driver. You can configure
    | driver-specific settings here. Each entry must include a 'driver'
    | key that matches the driver name the addon registers.
    |
    | Drivers are registered by addon packages (e.g. laravel-geolocate/freeipapi).
    | Install the addon package, and it will be auto-discovered by Laravel.
    |
    */

    'drivers' => [

        'freeipapi' => [
            'driver' => 'freeipapi',
            'base_url' => env('GEOLOCATE_FREEIPAPI_URL', 'https://freeipapi.com'),
            'api_key' => env('GEOLOCATE_FREEIPAPI_KEY'),
            'server' => env('GEOLOCATE_FREEIPAPI_SERVER', 'free'),
            'timeout' => 5,
        ],

    ],

];
