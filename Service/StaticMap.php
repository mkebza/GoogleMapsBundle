<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\GoogleMaps\Service;

use Symfony\Component\OptionsResolver\OptionsResolver;

class StaticMap
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string|null
     */
    private $locale;

    /**
     * StaticMap constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey, ?string $locale)
    {
        $this->apiKey = $apiKey;
        $this->locale = $locale;
    }

    public function generateUrl(array $params): string
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setDefaults([
                'key' => $this->apiKey,
                'size' => '300x300',
                'center' => null,
                'zoom' => null,
                'scale' => null,
                'format' => 'png',
                'maptype' => 'roadmap',
                'language' => $this->locale,
                'markers' => [],
            ])
            ->setAllowedValues('format', ['png', 'png8', 'gif', 'jpg', 'jpg-baseline'])
            ->setAllowedTypes('markers', [Marker::class.'[]'])
            ->setAllowedTypes('size', ['string', 'array'])
            ->setAllowedTypes('zoom', ['int', 'float', 'null'])
            ->setAllowedTypes('scale', ['int', 'float', 'null'])
            ->setAllowedTypes('language', ['string', 'null'])
            ->setAllowedValues('maptype', ['roadmap', 'satellite', 'hybrid', 'terrain']);

        $params = $resolver->resolve($params);

        if (is_array($params['size'])) {
            $params['size'] = implode('x', $params['size']);
        }

        if (!empty($params['markers'])) {
            $params['markers'] = array_map(function (Marker $m) { return (string) $m; }, $params['markers']);
        }

        $queryUrl = http_build_query($params);

        // Google expects markers=, markers= not markers[0] ... like http_build_query produces
        $queryUrl = preg_replace('/(%5B\d+%5D)/', '', $queryUrl);

        return 'https://maps.googleapis.com/maps/api/staticmap?'.$queryUrl;
    }
}
