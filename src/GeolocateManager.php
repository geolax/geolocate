<?php

namespace Geolax\Geolocate;

use Closure;
use Geolax\Geolocate\Contracts\Driver;
use Geolax\Geolocate\Data\GeolocationResult;
use Geolax\Geolocate\Exceptions\DriverNotFoundException;
use Illuminate\Support\Manager;

class GeolocateManager extends Manager
{
    /**
     * Registered driver factories keyed by driver name.
     *
     * @var array<string, Closure>
     */
    protected array $factories = [];

    /**
     * Get the default driver name.
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('geolocate.default', 'freeipapi');
    }

    /**
     * Register a driver factory.
     *
     * Addon packages use this to plug in their own drivers
     * without modifying the base package.
     */
    public function extend($driver, Closure $callback): static
    {
        $this->factories[$driver] = $callback;

        return $this;
    }

    /**
     * Create a new driver instance.
     *
     * Resolves the actual driver name from the config entry's 'driver' key,
     * allowing the config alias to differ from the registered driver name.
     *
     * @throws DriverNotFoundException
     */
    protected function createDriver($driver): Driver
    {
        $config = $this->config->get("geolocate.drivers.{$driver}", []);
        $resolvedDriver = $config['driver'] ?? $driver;

        if (isset($this->factories[$resolvedDriver])) {
            return $this->buildDriver($resolvedDriver, $config);
        }

        throw DriverNotFoundException::make($resolvedDriver);
    }

    /**
     * Build a driver instance from its registered factory.
     *
     * @param  array<string, mixed>  $config
     */
    protected function buildDriver(string $driver, array $config = []): Driver
    {
        $factory = $this->factories[$driver];

        return $factory($this->container, $config);
    }

    /**
     * Perform a lookup using the default driver.
     */
    public function lookup(?string $ip = null): GeolocationResult
    {
        return $this->driver()->lookup($ip);
    }

    /**
     * Dynamically pass methods to the default driver.
     *
     * @param  string  $method
     * @param  array<int, mixed>  $parameters
     */
    public function __call($method, $parameters): mixed
    {
        return $this->driver()->$method(...$parameters);
    }
}
