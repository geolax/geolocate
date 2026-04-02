<?php

namespace Geolax\Geolocate\Exceptions;

use RuntimeException;

class LookupFailedException extends RuntimeException
{
    public static function make(string $driver, string $reason, ?\Throwable $previous = null): static
    {
        return new static(
            "Geolocate lookup failed using [{$driver}] driver: {$reason}",
            previous: $previous,
        );
    }
}
