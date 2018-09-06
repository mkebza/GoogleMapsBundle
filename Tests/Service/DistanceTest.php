<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\GoogleMaps\Tests\Service;

use MKebza\GoogleMaps\Service\Distance;
use PHPUnit\Framework\TestCase;

class DistanceTest extends TestCase
{
    public function testGetDuration()
    {
        $distance = new Distance(100, 150);
        $this->assertSame(150, $distance->getDuration());
    }

    public function testGetDistance()
    {
        $distance = new Distance(3500, 150);
        $this->assertSame(3500.0, $distance->getDistance());
        $this->assertSame(3500.0, $distance->getDistance('m'));
        $this->assertSame(3.5, $distance->getDistance('km'));
        $this->assertSame(2.1747991728307, $distance->getDistance('mil'));
    }

    public function testGetDistanceUndefinedUnit()
    {
        $distance = new Distance(3500, 150);
        $this->expectException(\LogicException::class);
        $distance->getDistance('undefined');
    }

    public function testDurationInterval()
    {
        $distance = new Distance(100, 65);
        $this->assertEquals(\DateInterval::createFromDateString('1 minute 5 seconds'), $distance->getDurationInterval());
    }
}
