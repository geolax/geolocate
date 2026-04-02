# Geolax Geolocate

[![Latest Version on Packagist](https://img.shields.io/packagist/v/geolax/geolocate.svg?style=flat-square)](https://packagist.org/packages/geolax/geolocate)
[![Total Downloads](https://img.shields.io/packagist/dt/geolax/geolocate.svg?style=flat-square)](https://packagist.org/packages/geolax/geolocate)

Extensible geolocation lookup for Laravel — driver-based, addon-ready.

Geolax Geolocate provides a clean, driver-based architecture for IP geolocation. Install the base package, pick an addon (or build your own), and start looking up IPs in seconds.

## Installation

```bash
composer require geolax/geolocate
```

Publish the config file:

```bash
php artisan vendor:publish --tag="geolocate-config"
```

## Configuration

```php
// config/geolocate.php

return [
    'default' => env('GEOLOCATE_DRIVER', 'freeipapi'),

    'drivers' => [
        'freeipapi' => [
            'driver'   => 'freeipapi',
            'base_url' => env('GEOLOCATE_FREEIPAPI_URL', 'https://freeipapi.com'),
            'api_key'  => env('GEOLOCATE_FREEIPAPI_KEY'),
            'server'   => env('GEOLOCATE_FREEIPAPI_SERVER', 'free'),
            'timeout'  => 5,
        ],
    ],
];
```

## Available Addons

| Addon | Driver Name | Package |
|-------|------------|---------|
| [FreeIPAPI](https://freeipapi.com) | `freeipapi` | [`geolax/freeipapi`](https://github.com/geolax/freeipapi) |

> Install an addon alongside the base package. Addons are auto-discovered by Laravel — no manual registration needed.

## Usage

### Via Facade

```php
use Geolax\Geolocate\Facades\Geolocate;

$result = Geolocate::lookup('1.1.1.1');

$result->ipAddress;    // "1.1.1.1"
$result->countryName;  // "Australia"
$result->countryCode;  // "AU"
$result->cityName;     // "Sydney"
$result->latitude;     // -33.8688
$result->longitude;    // 151.209
$result->timezone;     // "Australia/Sydney"
$result->currency;     // "AUD"
$result->driver;       // "freeipapi"
```

### Via Dependency Injection

```php
use Geolax\Geolocate\Contracts\Driver;

class GeoController extends Controller
{
    public function __construct(private Driver $geolocate) {}

    public function locate(Request $request)
    {
        $result = $this->geolocate->lookup($request->ip());

        return response()->json($result->toArray());
    }
}
```

### Lookup Current Request IP

```php
// Pass null or no argument to look up the caller's IP
$result = Geolocate::lookup();
```

### Use a Specific Driver

```php
$result = Geolocate::driver('freeipapi')->lookup('8.8.8.8');
```

### Access Raw Provider Data

Each provider may return additional fields beyond the standard DTO. Access them via the `raw` property:

```php
$result = Geolocate::lookup('1.1.1.1');

$result->raw['asn'];             // "13335"
$result->raw['asnOrganization']; // "Cloudflare, Inc."
$result->raw['isProxy'];         // false
$result->raw['timeZones'];       // ["Australia/Sydney", "Australia/Melbourne", ...]
```

### The GeolocationResult DTO

Every lookup returns an immutable `GeolocationResult` with these properties:

| Property | Type | Description |
|----------|------|-------------|
| `ipVersion` | `?int` | 4 or 6 |
| `ipAddress` | `?string` | Resolved IP address |
| `latitude` | `?float` | Geographic latitude |
| `longitude` | `?float` | Geographic longitude |
| `countryName` | `?string` | Full country name |
| `countryCode` | `?string` | ISO 3166-1 alpha-2 |
| `regionName` | `?string` | State/province/region |
| `regionCode` | `?string` | Region code |
| `cityName` | `?string` | City name |
| `zipCode` | `?string` | Postal/ZIP code |
| `timezone` | `?string` | Primary timezone |
| `continent` | `?string` | Continent name |
| `continentCode` | `?string` | Continent code |
| `currency` | `?string` | Primary currency code |
| `driver` | `?string` | Driver that produced this result |
| `raw` | `array` | Full provider response |

## Creating Your Own Addon

Any developer can create a geolocation addon without modifying the base package.

### 1. Create a Driver

```php
<?php

namespace Acme\IpInfo;

use Geolax\Geolocate\Contracts\Driver;
use Geolax\Geolocate\Data\GeolocationResult;

class IpInfoDriver implements Driver
{
    public function __construct(protected array $config = []) {}

    public function lookup(?string $ip = null): GeolocationResult
    {
        // Call your API, then map the response:
        return new GeolocationResult(
            ipAddress: $ip,
            countryName: 'United States',
            countryCode: 'US',
            driver: 'ipinfo',
            raw: $apiResponse,
        );
    }
}
```

### 2. Create a Service Provider

```php
<?php

namespace Acme\IpInfo;

use Geolax\Geolocate\GeolocateManager;
use Illuminate\Support\ServiceProvider;

class IpInfoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->resolving(GeolocateManager::class, function (GeolocateManager $manager) {
            $manager->extend('ipinfo', function ($app, array $config) {
                return new IpInfoDriver($config);
            });
        });
    }
}
```

### 3. Add Auto-Discovery

In your addon's `composer.json`:

```json
{
    "extra": {
        "laravel": {
            "providers": [
                "Acme\\IpInfo\\IpInfoServiceProvider"
            ]
        }
    }
}
```

### 4. Users Configure It

```php
// config/geolocate.php
'default' => 'ipinfo',

'drivers' => [
    'ipinfo' => [
        'driver'  => 'ipinfo',
        'api_key' => env('IPINFO_API_KEY'),
    ],
],
```

That's it. The base package handles everything else.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Bishwajit Adhikary](https://github.com/bishwajitcadhikary)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
