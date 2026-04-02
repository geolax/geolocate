<?php

use Geolax\Geolocate\Data\GeolocationResult;

it('creates a GeolocationResult with all fields', function () {
    $result = new GeolocationResult(
        ipVersion: 4,
        ipAddress: '1.1.1.1',
        latitude: -33.8688,
        longitude: 151.209,
        countryName: 'Australia',
        countryCode: 'AU',
        regionName: 'New South Wales',
        regionCode: 'NSW',
        cityName: 'Sydney',
        zipCode: '4000',
        timezone: 'Australia/Sydney',
        continent: 'Oceania',
        continentCode: 'OC',
        currency: 'AUD',
        driver: 'test',
        raw: ['extra' => 'data'],
    );

    expect($result)
        ->ipVersion->toBe(4)
        ->ipAddress->toBe('1.1.1.1')
        ->latitude->toBe(-33.8688)
        ->longitude->toBe(151.209)
        ->countryName->toBe('Australia')
        ->countryCode->toBe('AU')
        ->regionName->toBe('New South Wales')
        ->regionCode->toBe('NSW')
        ->cityName->toBe('Sydney')
        ->zipCode->toBe('4000')
        ->timezone->toBe('Australia/Sydney')
        ->continent->toBe('Oceania')
        ->continentCode->toBe('OC')
        ->currency->toBe('AUD')
        ->driver->toBe('test')
        ->raw->toBe(['extra' => 'data']);
});

it('creates a GeolocationResult with default null values', function () {
    $result = new GeolocationResult;

    expect($result)
        ->ipVersion->toBeNull()
        ->ipAddress->toBeNull()
        ->latitude->toBeNull()
        ->longitude->toBeNull()
        ->countryName->toBeNull()
        ->countryCode->toBeNull()
        ->driver->toBeNull()
        ->raw->toBe([]);
});

it('converts to array format', function () {
    $result = new GeolocationResult(
        ipVersion: 4,
        ipAddress: '8.8.8.8',
        countryName: 'United States',
        countryCode: 'US',
        driver: 'test',
    );

    $array = $result->toArray();

    expect($array)
        ->toBeArray()
        ->toHaveKeys([
            'ip_version', 'ip_address', 'latitude', 'longitude',
            'country_name', 'country_code', 'region_name', 'region_code',
            'city_name', 'zip_code', 'timezone', 'continent',
            'continent_code', 'currency', 'driver',
        ])
        ->ip_version->toBe(4)
        ->ip_address->toBe('8.8.8.8')
        ->country_name->toBe('United States');
});

it('is immutable (readonly)', function () {
    $result = new GeolocationResult(ipAddress: '1.1.1.1');

    // This test verifies the class is readonly by attempting a reflection check
    $reflection = new ReflectionClass($result);
    expect($reflection->isReadOnly())->toBeTrue();
});
