<?php

namespace Geolax\Geolocate\Data;

readonly class GeolocationResult
{
    /**
     * @param  int|null  $ipVersion  IP version (4 or 6)
     * @param  string|null  $ipAddress  The resolved IP address
     * @param  float|null  $latitude  Geographic latitude
     * @param  float|null  $longitude  Geographic longitude
     * @param  string|null  $countryName  Full country name
     * @param  string|null  $countryCode  ISO 3166-1 alpha-2 country code
     * @param  string|null  $regionName  State/province/region name
     * @param  string|null  $regionCode  Region code
     * @param  string|null  $cityName  City name
     * @param  string|null  $zipCode  Postal/ZIP code
     * @param  string|null  $timezone  Primary timezone identifier
     * @param  string|null  $continent  Continent name
     * @param  string|null  $continentCode  Continent code
     * @param  string|null  $currency  Primary currency code
     * @param  string|null  $driver  The driver that produced this result
     * @param  array<string, mixed>  $raw  Raw API response data for provider-specific access
     */
    public function __construct(
        public ?int $ipVersion = null,
        public ?string $ipAddress = null,
        public ?float $latitude = null,
        public ?float $longitude = null,
        public ?string $countryName = null,
        public ?string $countryCode = null,
        public ?string $regionName = null,
        public ?string $regionCode = null,
        public ?string $cityName = null,
        public ?string $zipCode = null,
        public ?string $timezone = null,
        public ?string $continent = null,
        public ?string $continentCode = null,
        public ?string $currency = null,
        public ?string $driver = null,
        public array $raw = [],
    ) {}

    /**
     * Convert the DTO to an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'ip_version' => $this->ipVersion,
            'ip_address' => $this->ipAddress,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'country_name' => $this->countryName,
            'country_code' => $this->countryCode,
            'region_name' => $this->regionName,
            'region_code' => $this->regionCode,
            'city_name' => $this->cityName,
            'zip_code' => $this->zipCode,
            'timezone' => $this->timezone,
            'continent' => $this->continent,
            'continent_code' => $this->continentCode,
            'currency' => $this->currency,
            'driver' => $this->driver,
        ];
    }
}
