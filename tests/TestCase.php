<?php

namespace Geolax\Geolocate\Tests;

use Geolax\Geolocate\Facades\Geolocate;
use Geolax\Geolocate\GeolocateServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            GeolocateServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Geolocate' => Geolocate::class,
        ];
    }
}
