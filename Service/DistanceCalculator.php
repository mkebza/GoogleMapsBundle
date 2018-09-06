<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\GoogleMaps\Service;

use GuzzleHttp\Client;
use MKebza\GoogleMaps\Entity\Embeddable\Location;
use MKebza\GoogleMaps\Exception\GoogleMapsApiException;

class DistanceCalculator
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * DistanceCalculator constructor.
     */
    public function __construct(Client $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function distance(Location $origin, Location $destination): ?Distance
    {
        $url = sprintf('https://maps.googleapis.com/maps/api/distancematrix/json?key=%s&origins=%s,%s&destinations=%s,%s',
            $this->apiKey,
            $origin->getLatitude(), $origin->getLongitude(),
            $destination->getLatitude(), $destination->getLongitude()
        );

        $response = $this->client->get($url);

        if (200 !== $response->getStatusCode()) {
            return null;
        }

        $data = json_decode($response->getBody()->getContents());

        if ('OK' !== $data->status) {
            throw new GoogleMapsApiException(sprintf('%s: %s', $data->status, $data->error_message));
        }

        $element = $data->rows[0]->elements[0];

        if ('OK' !== $element->status) {
            throw new GoogleMapsApiException(sprintf('%s: Invalid data for API', $element->status));
        }

        return new Distance($element->distance->value, $element->duration->value);
    }
}
