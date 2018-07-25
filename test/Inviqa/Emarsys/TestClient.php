<?php

namespace test\Inviqa\Emarsys;

use GuzzleHttp\Psr7\Response;
use Inviqa\Emarsys\Api\Client;
use Psr\Http\Message\ResponseInterface;

class TestClient implements Client
{
    public function requestAccountSettings(): string
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

        return $json;
    }

    public function sendCSVContent(string $csvFileAbsolutePath): ResponseInterface
    {
        return new Response();
    }
}
