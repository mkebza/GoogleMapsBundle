<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\GoogleMaps\Twig\Runtime;

use MKebza\GoogleMaps\Entity\Embeddable\Location;
use MKebza\GoogleMaps\Service\Distance;
use MKebza\GoogleMaps\Service\DistanceCalculator;
use Psr\SimpleCache\CacheInterface;
use Twig\Extension\RuntimeExtensionInterface;

class DistanceRuntime implements RuntimeExtensionInterface
{
    /**
     * @var DistanceCalculator
     */
    private $calculator;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * DistanceRuntime constructor.
     *
     * @param DistanceCalculator $calculator
     */
    public function __construct(DistanceCalculator $calculator, CacheInterface $cache)
    {
        $this->calculator = $calculator;
        $this->cache = $cache;
    }

    /**
     * @param Location               $origin
     * @param Location               $destination
     * @param null|\DateInterval|int $cacheFor    - Cache interval
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return null|Distance
     */
    public function distance(Location $origin, Location $destination, $cacheFor = 3600): ?Distance
    {
        $cacheKey = $origin->getLatitudeLongitude().$destination->getLatitudeLongitude();
        $distance = $this->cache->get($cacheKey);

        if (null === $distance) {
            $distance = $this->calculator->distance($origin, $destination);
            if (null !== $distance) {
                $this->cache->set($cacheKey, $distance, $cacheFor);
            }
        }

        return $distance;
    }
}
