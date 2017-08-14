<p align="center">
    <img src="http://i.imgur.com/dmdhxRl.png">
    <h1 align="center">Support - ConsoleTVs support library</h1>
</p>

## Description

Support is the library I use in my latest projects and packages to
make things easy. It features helper functions that can be used at any time.

## Installation

```
composer require consoletvs/support
```

Register the service provider to the current project (Not needed if using laravel 5.5+):

```
ConsoleTVs\Support\SupportServiceProvider::class
```

Publish the configuration:

```
php artisan vendor:publish
```

## Usage

No docs are currently provided. If you want to know what functions are available
just check the traits. They are organized by categories.
