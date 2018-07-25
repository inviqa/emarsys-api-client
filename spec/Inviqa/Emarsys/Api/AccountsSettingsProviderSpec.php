<?php

namespace spec\Inviqa\Emarsys\Api;

use Inviqa\Emarsys\Api\AccountsSettingsProvider;
use Inviqa\Emarsys\Api\Client;
use Inviqa\Emarsys\Api\Response\AccountsResponse;
use Inviqa\Emarsys\Api\Response\ClientResponse;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AccountsSettingsProviderSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client);
    }

    function it_returns_an_account_response(Client $client, ClientResponse $clientResponse)
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
        $clientResponse->getBodyContents()->willReturn($json);
        $client->requestAccountSettings()->willReturn($clientResponse);

        $this->fetchAccountSettings()->shouldBeLike(AccountsResponse::fromClientResponse($clientResponse->getWrappedObject()));
    }
}
