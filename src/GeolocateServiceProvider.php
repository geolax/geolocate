<?php

namespace Geolax\Geolocate;

use Geolax\Geolocate\Contracts\Driver;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GeolocateServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('geolocate')
            ->hasConfigFile();
    }

    public function registeringPackage(): void
    {
        $this->app->singleton(GeolocateManager::class, function ($app) {
            return new GeolocateManager($app);
        });

        $this->app->bind(Driver::class, function ($app) {
            return $app->make(GeolocateManager::class)->driver();
        });
    }
}
