<?php

namespace spec\Inviqa\Emarsys\Api\Request\Accounts;

use Inviqa\Emarsys\Api\Client\Accounts\Client;
use Inviqa\Emarsys\Api\Response\Accounts\AccountsResponseProvider;
use Inviqa\Emarsys\Api\Response\Accounts\AccountsResponse;
use PhpSpec\ObjectBehavior;

class AccountsSettingsProviderSpec extends ObjectBehavior
{
    function let(
        AccountsResponseProvider $accountsResponseProvider,
        Client $client
    ) {
        $this->beConstructedWith($accountsResponseProvider, $client);
    }

    function it_sets_up_the_account_settings_request(
        AccountsResponseProvider $accountsResponseProvider,
        Client $client
    ) {
        $json = <<< 'EOD'
{
  "replyCode": 0,
  "replyText": "OK"
}
EOD;

        $client->requestAccountSettings()->willReturn($json);
        $response = new AccountsResponse(0, 'OK', []);
        $accountsResponseProvider->provide($json)->willReturn($response);

        $this->fetchAccountSettings()->shouldBeLike($response);
    }
}
