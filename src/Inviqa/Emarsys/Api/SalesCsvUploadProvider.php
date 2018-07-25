<?php

namespace Inviqa\Emarsys\Api;

use Inviqa\Emarsys\Api\Response\SalesResponse;

class SalesCsvUploadProvider
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function sendCsvContent(string $csvContent): SalesResponse
    {
        return SalesResponse::fromHttpResponse($this->client->sendCSVContent($csvContent));
    }
}
