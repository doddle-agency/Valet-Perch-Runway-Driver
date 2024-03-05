# Valet 4.6.1, Perch Runway Driver
Perch Runway Driver for Laravel Valet 4.6.1

## Working in progress - Does not work
Hi 👋, I'd welcome help getting this to work, the core of the issue appears to be with lines 56 through to 73. Resulting in assets returning a 404 even though the paths are correct.

## Testing on
- [Perch Runway 3.2](https://docs.grabaperch.com/runway/getting-started/installing/rewrites/)
- [Laravel Valet 4.6.1](https://laravel.com/docs/10.x/valet)
- PHP 8.0.30

## Assumptions
You have Laravel Valet install and running.

## Installation
1. Copy `PerchRunwayValetDriver.php` into `{user}/.config/valet/drivers` folder
2. Restart valet `valet restart`
3. As per Perch Doc's, add Nginx rules (may not be necessary)
```
    # Match just the homepage
    location = / {
        try_files $uri @runway;
    }

    # Match any other request
    location / {
        try_files $uri $uri/ @runway;
    }

    # Perch Runway
    location @runway {
        rewrite ^ /perch/core/runway/start.php last;
    }
```
