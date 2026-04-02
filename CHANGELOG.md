# Changelog

All notable changes to `geolocate` will be documented in this file.

## v1.1.0 - 2026-04-02

### Added

- Support for **Laravel 11** and **Laravel 12**
- PHP 8.2+ runtime compatibility (lowered from 8.4)
- CI matrix testing against Laravel 11/12/13 with PHP 8.3 and 8.4

### Changed

- `php` constraint: `^8.4` → `^8.2`
- `orchestra/testbench` (dev): `^11.0.0` → `^9.0 || ^10.0 || ^11.0`

## v1.0.0 - 2026-04-02

### 🚀 Initial Release

Extensible geolocation lookup for Laravel — driver-based, addon-ready.

#### Features

- **Driver-based architecture** using Laravel's Manager pattern
- **GeolocationResult DTO** — immutable, readonly data object with all common geolocation fields
- **Addon system** — third-party developers can create their own drivers without modifying the base package
- **Facade & DI support** — use `Geolocate::lookup()` or inject `Driver` contract
- **Config-driven** — each driver has its own config under `geolocate.drivers`

#### Available Addons

- [`geolax/freeipapi`](https://github.com/geolax/freeipapi) — FreeIPAPI driver
