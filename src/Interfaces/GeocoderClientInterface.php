<?php

declare(strict_types=1);

namespace App\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface GeocoderClientInterface
{
    public function request(string $address): void;
    public function getResponse(): ?ResponseInterface;
}
