# Changelog

All notable changes to `geolocate` will be documented in this file.

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
