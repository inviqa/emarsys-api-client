<?php

namespace Inviqa\Emarsys\Api\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use Inviqa\Emarsys\Api\Client;
use Inviqa\Emarsys\Api\Configuration;
use Inviqa\Emarsys\Api\Response\ClientResponse;

class HttpClient implements Client
{
    private $client;

    private $authenticationHeaderProvider;

    private $adminClient;

    private $configuration;

    public function __construct(
        AuthenticationHeaderProvider $authenticationHeaderProvider,
        Configuration $configuration
    ) {
        $this->configuration = $configuration;
        $this->authenticationHeaderProvider = $authenticationHeaderProvider;
        $this->client = new GuzzleClient([
            'base_uri' => $configuration->getEndpointUrl(),
        ]);
        $this->adminClient = new GuzzleClient([
            'base_uri' => sprintf($configuration->getSalesEndpointUrl(), $configuration->getMerchantCode()),
        ]);
    }

    public function requestAccountSettings(): ClientResponse
    {
        try {
            $response = $this->client->get('settings', [
                'headers' => [
                    'Content-type' => 'application/json; charset="utf-8"',
                    'X-WSSE' => $this->authenticationHeaderProvider->settingsAuthenticationHeader(),
                ],
            ]);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        return ClientResponse::fromResponseInterface($response);
    }

    public function sendCSVContent(string $csvContent): ClientResponse
    {
        try {
            $response = $this->adminClient->post('api', [
                'headers' => [
                    'Content-type' => 'text/csv',
                    'Accept' => 'text/plain',
                    'Content-Encoding' => 'gzip',
                    'Authorization' => $this->authenticationHeaderProvider->salesAuthenticationHeader(),
                ],
                'body' => \GuzzleHttp\Psr7\stream_for(gzencode($csvContent)),
            ]);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        return ClientResponse::fromResponseInterface($response);
    }

    public function addOrUpdateContact(array $contactContent): ClientResponse
    {
        try {
            $client = new GuzzleClient();
            $response = $client->put($this->configuration->getEndpointUrl() . '/contact/?create_if_not_exists=1', [
                'headers' => [
                    'Content-type' => 'application/json; charset="utf-8"',
                    'Accept' => 'application/json; charset="utf-8"',
                    'X-WSSE' => $this->authenticationHeaderProvider->settingsAuthenticationHeader(),
                ],
                'body' => json_encode($contactContent),
            ]);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        return ClientResponse::fromResponseInterface($response);
    }

    public function deleteContact(array $contactContent): ClientResponse
    {
        try {
            $client = new GuzzleClient();
            $response = $client->post($this->configuration->getEndpointUrl() . '/contact/delete', [
                'headers' => [
                    'Content-type' => 'application/json; charset="utf-8"',
                    'Accept' => 'application/json; charset="utf-8"',
                    'X-WSSE' => $this->authenticationHeaderProvider->settingsAuthenticationHeader(),
                ],
                'body' => json_encode($contactContent),
            ]);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        return ClientResponse::fromResponseInterface($response);
    }

    public function optOutContact(array $contactContent): ClientResponse
    {
        try {
            $client = new GuzzleClient();
            $response = $client->post($this->configuration->getEndpointUrl() . '/email/unsubscribe', [
                'headers' => [
                    'Content-type' => 'application/json; charset="utf-8"',
                    'Accept' => 'application/json; charset="utf-8"',
                    'X-WSSE' => $this->authenticationHeaderProvider->settingsAuthenticationHeader(),
                ],
                'body' => json_encode($contactContent),
            ]);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        return ClientResponse::fromResponseInterface($response);
    }
}
