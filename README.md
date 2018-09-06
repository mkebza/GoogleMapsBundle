Installation
============

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require mkebza/google-maps-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require <package-name>
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new <vendor>\<bundle-name>\<bundle-long-name>(),
        );

        // ...
    }

    // ...
}
```

# Configuration

Bundle requires only one configuration, Google Map API key,

```yaml
m_kebza_google_maps:
    api_key: <your api key>
```

# Features

## Location embeddable

This bundle provides `Location` (`MKebza\GoogleMaps\Entity\Embeddable\Location`) 
which can be used in your doctrine entiteis. This type provides as well shortcut
for creating markers `getMarker(...)`

## Distance
For calculation you can use either `MKebza\GoogleMaps\Service\DistanceCalculator` service 
which uses Location object as its arguments or in your twig templates helper `gmaps_distance(origin, destination)`.

Both returns `MKebza\GoogleMaps\Service\Distance`, which hold information about duration / distance 
and can convert basic units as well.

## Static maps

Again there is service `MKebza\GoogleMaps\Service\StaticMap` and twig helper `gmaps_static` which
both have same set of arguments.

Parameters:

- `key` - Your google maps api key, automatically taken from configuration
- `size` - can be either `300x300` or `[300, 300]` format
- `center` - center point for your google map
- `zoom` - zoom level
- `scale` - density of pixels
- `format` - required image format, default png
- `maptype` - requested maptype, default roadmap
- `language` - requested language, default your app locale
- `markers` - array of `MKebza\GoogleMaps\Service\Marker` objects to display in the map


### Markers

Markers can be created from options object or by itself, they function as factory with 
methods `fromLatitudeLongitude($lat, $long, $params)` and 
`fromName($name, $params)`.

Parameters:

- `size` - size of marker
- `color` - hex color, eg. `333333` for gray
- `label` - One letter label for marker
- `icon` - URL to icon
- `anchor` - anchor for icon 


For more documentation look at https://developers.google.com/maps/documentation/maps-static/intro 
  
