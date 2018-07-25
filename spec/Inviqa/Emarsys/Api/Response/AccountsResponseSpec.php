<?php

namespace spec\Inviqa\Emarsys\Api\Response;

use Inviqa\Emarsys\Api\Response\ClientResponse;
use PhpSpec\ObjectBehavior;

class AccountsResponseSpec extends ObjectBehavior
{
    function it_should_build_a_valid_accounts_response(ClientResponse $clientResponse)
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
        $this->beConstructedFromClientResponse($clientResponse);

        $this->isSuccessful()->shouldReturn(true);
        $this->getReplyCode()->shouldReturn("0");
        $this->getReplyText()->shouldReturn("OK");
        $this->getJsonEncodedData()->shouldReturn([
            'environment' => 'suite.emarsys.com',
            'timezone' => 'America/New_York',
            'name' => 'Heimdall',
            'password_history_queue_size' => 3,
            'country' => 'United States of America',
        ]);
    }

    function it_should_throw_exception_when_data_is_missing(ClientResponse $clientResponse)
    {
        $json = <<< 'EOD'
{
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
        $this->beConstructedFromClientResponse($clientResponse);

        $this->shouldThrow(new \InvalidArgumentException('Cannot instantiate Emarsys Accounts Response object because of the replyCode is missing from the response'))->duringInstantiation();

        $json = <<< 'EOD'
{
  "replyCode": "0",
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
        $this->beConstructedFromClientResponse($clientResponse);

        $this->shouldThrow(new \InvalidArgumentException('Cannot instantiate Emarsys Accounts Response object because of the replyText is missing from the response'))->duringInstantiation();
    }

    function it_should_throw_an_exception_when_the_json_cannot_be_decoded(ClientResponse $clientResponse)
    {
        $clientResponse->getBodyContents()->willReturn('');
        $this->beConstructedFromClientResponse($clientResponse);

        $this->shouldThrow(new \InvalidArgumentException('Cannot instantiate Emarsys Accounts Response object due to an empty response body'))->duringInstantiation();
    }
}
