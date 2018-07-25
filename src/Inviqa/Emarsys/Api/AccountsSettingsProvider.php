<?php

namespace Inviqa\Emarsys\Api;

use Inviqa\Emarsys\Api\Response\AccountsResponse;

class AccountsSettingsProvider
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetchAccountSettings(): AccountsResponse
    {
        return AccountsResponse::fromClientResponse($this->client->requestAccountSettings());
    }
}
