<?php

namespace Geolax\Geolocate\Facades;

use Geolax\Geolocate\Contracts\Driver;
use Geolax\Geolocate\Data\GeolocationResult;
use Geolax\Geolocate\GeolocateManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static GeolocationResult lookup(?string $ip = null)
 * @method static Driver driver(?string $driver = null)
 * @method static GeolocateManager extend(string $driver, \Closure $callback)
 *
 * @see GeolocateManager
 */
class Geolocate extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GeolocateManager::class;
    }
}
