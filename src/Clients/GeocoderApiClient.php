<?php

declare(strict_types=1);

namespace App\Clients;

use App\Interfaces\GeocoderClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class GeocoderApiClient implements GeocoderClientInterface
{
    private ?ResponseInterface $response = null;

    public function __construct(
        private ClientInterface $client,
        private string $url,
        private string $apiKey = '',
        private LoggerInterface $logger = new NullLogger()
    ) {

    }

    public function request(string $address): void
    {
        $request = new Request('GET', $this->url, [
            'query' => [
                'geocode' => $address,
                'apikey' => $this->apiKey,
                'format' => 'json'
            ],
        ]);
        try {
            $this->response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $exception) {
            $this->logger->error($exception->getMessage());
        }
    }

    public function getResponse(): ?ResponseInterface
    {
        if ($this->response === null) {
            return null;
        }

        return $this->response;
    }
}
