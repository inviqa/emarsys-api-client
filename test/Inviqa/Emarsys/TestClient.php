<?php

namespace test\Inviqa\Emarsys;

use GuzzleHttp\Psr7\Response;
use Inviqa\Emarsys\Api\Client;
use Inviqa\Emarsys\Api\Response\ClientResponse;
use Psr\Http\Message\ResponseInterface;

class TestClient implements Client
{
    public function requestAccountSettings(): ClientResponse
    {
        $json = <<< 'EOD'
{
  "replyCode": 0,
  "replyText": "OK",
  "data": {
    "environment": "suite.emarsys.com",
    "timezone": "America/New_York",
    "name": "Heimdall",
    "password_history_queue_size": 3,
    "country": "United States of America"
  }
}
EOD;
        $response = new Response(200, [], $json);

        return ClientResponse::fromResponseInterface($response);
    }

    public function sendCSVContent(string $csvFileAbsolutePath): ClientResponse
    {
        return ClientResponse::fromResponseInterface(new Response());
    }

    public function addContact(array $contactContent): ClientResponse
    {
        return ClientResponse::fromResponseInterface(new Response());
    }
}
