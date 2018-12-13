<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\GoogleMaps\Twig\Extension;

use MKebza\GoogleMaps\Twig\Runtime\StaticMapRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class StaticMapExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('gmaps_static', [StaticMapRuntime::class, 'map']),
            new TwigFunction('gmaps_marker_name', [StaticMapRuntime::class, 'markerName']),
            new TwigFunction('gmaps_marker_lat_long', [StaticMapRuntime::class, 'markerLatLong']),
        ];
    }
}
