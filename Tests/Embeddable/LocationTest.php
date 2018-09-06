<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\GoogleMaps\Tests\Entity\Embeddable;

use MKebza\GoogleMaps\Entity\Embeddable\Location;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testGetLatitudeLongitude()
    {
        $location = new Location();
        $location->setLatitude('5.0')->setLongitude('11.1');

        $this->assertSame('5.0,11.1', $location->getLatitudeLongitude());
    }
}
