<?php

namespace Geolax\Geolocate\Exceptions;

use InvalidArgumentException;

class DriverNotFoundException extends InvalidArgumentException
{
    public static function make(string $driver): static
    {
        return new static("Geolocate driver [{$driver}] is not registered. Did you install and configure the addon package?");
    }
}
