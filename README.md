# Perch Runway Driver for Laravel Valet 4
Perch Runway Driver for Laravel Valet 4. Tested on Valet 4.6.1.

## Set up
1. Change parameters on line 10 to suit your setup
2. Change the location of your static assets, set as `'/dist'` by default

## Tested on
- [Perch Runway 3.2](https://docs.grabaperch.com/runway/getting-started/installing/rewrites/)
- [Laravel Valet 4.6.1](https://laravel.com/docs/10.x/valet)
- PHP 8.0.30

## Assumptions
You have Laravel Valet installed and running with your site folder linked or parked.

## Installation
1. Copy `PerchRunwayValetDriver.php` into `{user}/.config/valet/drivers` folder
2. Restart valet `valet restart`
