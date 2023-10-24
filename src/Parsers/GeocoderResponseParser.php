<?php

declare(strict_types=1);

namespace App\Parsers;

use Psr\Http\Message\ResponseInterface;

class GeocoderResponseParser
{
    public function parse(?ResponseInterface $response): ?string
    {
        if ($response === null) {
            return null;
        }

        $jsonData = json_decode($response->getBody()->getContents(), true);
        $objects = $jsonData['response']['GeoObjectCollection']['featureMember'];

        return $objects[0]['GeoObject']['Point']['pos'] ?? null;
    }
}
