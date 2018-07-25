<?php

namespace Inviqa\Emarsys\Api\Client;

use GuzzleHttp\Client as GuzzleClient;
use Inviqa\Emarsys\Api\Client;
use Inviqa\Emarsys\Api\Configuration;
use Psr\Http\Message\ResponseInterface;

class HttpClient implements Client
{
    private $client;

    private $authenticationHeaderProvider;

    private $adminClient;

    public function __construct(
        AuthenticationHeaderProvider $authenticationHeaderProvider,
        Configuration $configuration
    ) {
        $this->authenticationHeaderProvider = $authenticationHeaderProvider;
        $this->client = new GuzzleClient([
            'base_uri' => $configuration->getEndpointUrl(),
        ]);
        $this->adminClient = new GuzzleClient([
            'base_uri' => sprintf($configuration->getSalesEndpointUrl(), $configuration->getMerchantCode()),
        ]);
    }

    public function requestAccountSettings(): string
    {
        $response = $this->client->get('settings', [
            'headers' => [
                'Content-type' => 'application/json; charset="utf-8"',
                'X-WSSE' => $this->authenticationHeaderProvider->settingsAuthenticationHeader(),
            ],
        ]);

        return (string) $response->getBody()->getContents();
    }

    public function sendCSVContent(string $csvContent): ResponseInterface
    {
        return $this->adminClient->post('api', [
            'headers' => [
                'Content-type' => 'text/csv',
                'Accept' => 'text/plain',
                'Content-Encoding' => 'gzip',
                'Authorization' => $this->authenticationHeaderProvider->salesAuthenticationHeader(),
            ],
            'body' => \GuzzleHttp\Psr7\stream_for(gzencode($csvContent)),
        ]);
    }
}
