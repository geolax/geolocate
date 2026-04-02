<?php

namespace Geolax\Geolocate\Contracts;

use Geolax\Geolocate\Data\GeolocationResult;

interface Driver
{
    /**
     * Lookup geolocation data for the given IP address.
     *
     * @param  string|null  $ip  The IP address to look up. Null for the current request IP.
     */
    public function lookup(?string $ip = null): GeolocationResult;
}
