<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\GoogleMaps\Entity\Embeddable;

use Doctrine\ORM\Mapping as ORM;
use MKebza\GoogleMaps\Service\Marker;

/**
 * Class Location.
 *
 * @ORM\Embeddable()
 */
class Location
{
    /**
     * @var null|string
     *
     * @ORM\Column(type="decimal", precision=10, scale=6, nullable=false)
     */
    private $latitude;

    /**
     * @var null|string
     *
     * @ORM\Column(type="decimal", precision=10, scale=6, nullable=false)
     */
    private $longitude;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    private $name;

    /**
     * @return null|string
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * @param null|string $latitude
     *
     * @return Location
     */
    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * @param null|string $longitude
     *
     * @return Location
     */
    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     *
     * @return Location
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLatitudeLongitude(): string
    {
        return sprintf('%s,%s', $this->getLatitude(), $this->getLongitude());
    }

    public function getMarker(array $options = []): Marker
    {
        return Marker::fromLatitudeLongitude($this->getLatitude(), $this->getLongitude(), $options);
    }
}
