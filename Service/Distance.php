<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\GoogleMaps\Service;

class Distance
{
    /**
     * @var int
     */
    private $distance;

    /**
     * @var int
     */
    private $duration;

    /**
     * Distance constructor.
     *
     * @param int $distance in meters
     * @param int $duration in seconds
     */
    public function __construct(int $distance, int $duration)
    {
        $this->distance = $distance;
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param mixed $unit
     *
     * @return float
     */
    public function getDistance($unit = 'm'): float
    {
        switch ($unit) {
            case 'm':
                return $this->distance;
            case 'km':
                return $this->distance / 1000;
            case 'mil':
                return $this->distance / 1609.344;
            default:
                throw new \LogicException(sprintf("Invalid unit for distance '%s'", $unit));
        }
    }

    /**
     * @return \DateInterval
     */
    public function getDurationInterval(): \DateInterval
    {
        $dtZero = new \DateTime('@0');
        $dtSeconds = new \DateTime('@'.$this->getDuration());

        return $dtZero->diff($dtSeconds);
    }
}
