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

    /**
     * @throws \LogicException
     */
    public function sendCsvContent(string $csvContent): SalesResponse
    {
        return SalesResponse::fromClientResponse($this->client->sendCSVContent($csvContent));
    }
}
