<?php

namespace App\Services;

use App\Entity\Address;
use App\Exceptions\PositionNotFoundException;
use App\Interfaces\GeocoderClientInterface;
use App\Parsers\GeocoderResponseParser;

class GetAddressPositionService
{
    public function __construct(
        public readonly GeocoderClientInterface $client,
        public GeocoderResponseParser $parser
    ) {
    }

    /**
     * @throws PositionNotFoundException
     */
    public function run(string $address): string
    {
        $this->client->request($address);
        $response = $this->client->getResponse();
        $point = $this->parser->parse($response);

        if ($point === null) {
            throw new PositionNotFoundException($address);
        }

        return "POINT($point)";
    }
}
