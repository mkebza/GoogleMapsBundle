<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\GoogleMaps\Service;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Marker
{
    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    private $searchName;

    private $name;
    private $options;

    private function __construct($latitude, $longitude, $searchName, $options)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->searchName = $searchName;
        $this->options = $this->resolveOptions($options);
    }

    public function __toString()
    {
        $passOptions = null === $this->options['icon'] ? ['size', 'color', 'label'] : ['icon', 'anchor'];

        $options = [];
        foreach ($passOptions as $key) {
            if (null !== $this->options[$key]) {
                $options[] = sprintf('%s:%s', $key, $this->options[$key]);
            }
        }

        $location = null === $this->searchName ? $this->latitude.','.$this->longitude : $this->searchName;

        return implode('|', $options).'|'.$location;
    }

    public static function fromLatitudeLongitude($latitude, $longitude, array $options = []): self
    {
        return new self($latitude, $longitude, null, $options);
    }

    public static function fromName($name, array $options = []): self
    {
        return new self(null, null, $name, $options);
    }

    private function resolveOptions(array $options): array
    {
        return (new OptionsResolver())
            ->setDefaults([
                'size' => null,
                'color' => null,
                'label' => null,
                'icon' => null,
                'anchor' => null,
            ])
            ->setAllowedValues('size', ['tiny', 'mid', 'small', null])
            ->setNormalizer('color', function (Options $options, $color) {
                $color = preg_replace('/(#|0x)/', '', $color);

                return '0x'.$color;
            })
            ->setAllowedTypes('color', ['string', 'null'])
            ->setAllowedTypes('label', ['string', 'null'])
            ->setAllowedTypes('icon', ['string', 'null'])
            ->setAllowedValues('anchor', ['top', 'bottom', 'left', 'right', 'center', 'topleft', 'topright', 'bottomleft', 'bottomright', null])
            ->resolve($options);
    }
}
