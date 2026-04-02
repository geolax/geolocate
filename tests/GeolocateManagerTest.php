<?php

use Geolax\Geolocate\Contracts\Driver;
use Geolax\Geolocate\Data\GeolocationResult;
use Geolax\Geolocate\Exceptions\DriverNotFoundException;
use Geolax\Geolocate\Facades\Geolocate;
use Geolax\Geolocate\GeolocateManager;

it('registers the GeolocateManager as a singleton', function () {
    $manager = app(GeolocateManager::class);

    expect($manager)->toBeInstanceOf(GeolocateManager::class);
    expect(app(GeolocateManager::class))->toBe($manager);
});

it('throws DriverNotFoundException for unregistered driver', function () {
    app(GeolocateManager::class)->driver('nonexistent');
})->throws(DriverNotFoundException::class);

it('allows extending with custom drivers', function () {
    $manager = app(GeolocateManager::class);

    $manager->extend('test', function ($app, array $config) {
        return new class implements Driver
        {
            public function lookup(?string $ip = null): GeolocationResult
            {
                return new GeolocationResult(
                    ipVersion: 4,
                    ipAddress: $ip ?? '127.0.0.1',
                    countryName: 'Testland',
                    countryCode: 'TL',
                    driver: 'test',
                );
            }
        };
    });

    $result = $manager->driver('test')->lookup('8.8.8.8');

    expect($result)
        ->toBeInstanceOf(GeolocationResult::class)
        ->ipAddress->toBe('8.8.8.8')
        ->countryName->toBe('Testland')
        ->countryCode->toBe('TL')
        ->driver->toBe('test');
});

it('resolves the Driver contract to the default driver', function () {
    Geolocate::extend('freeipapi', function ($app, array $config) {
        return new class implements Driver
        {
            public function lookup(?string $ip = null): GeolocationResult
            {
                return new GeolocationResult(
                    ipAddress: '1.1.1.1',
                    driver: 'freeipapi',
                );
            }
        };
    });

    $driver = app(Driver::class);

    expect($driver)->toBeInstanceOf(Driver::class);
    expect($driver->lookup()->driver)->toBe('freeipapi');
});

it('returns the default driver name from config', function () {
    config(['geolocate.default' => 'custom']);

    $manager = app(GeolocateManager::class);

    expect($manager->getDefaultDriver())->toBe('custom');
});

it('passes driver config to the creator callback', function () {
    config(['geolocate.drivers.configtest' => ['api_key' => 'secret123']]);

    $capturedConfig = null;

    $manager = app(GeolocateManager::class);
    $manager->extend('configtest', function ($app, array $config) use (&$capturedConfig) {
        $capturedConfig = $config;

        return new class implements Driver
        {
            public function lookup(?string $ip = null): GeolocationResult
            {
                return new GeolocationResult(driver: 'configtest');
            }
        };
    });

    $manager->driver('configtest');

    expect($capturedConfig)->toBe(['api_key' => 'secret123']);
});
