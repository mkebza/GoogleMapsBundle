<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\GoogleMaps\Twig\Runtime;

use MKebza\GoogleMaps\Service\StaticMap;
use Twig\Extension\RuntimeExtensionInterface;

class StaticMapRuntime implements RuntimeExtensionInterface
{
    /**
     * @var StaticMap
     */
    private $generator;

    /**
     * StaticMapRuntime constructor.
     *
     * @param StaticMap $generator
     */
    public function __construct(StaticMap $generator)
    {
        $this->generator = $generator;
    }

    public function map(array $params): string
    {
        return $this->generator->generateUrl($params);
    }
}
