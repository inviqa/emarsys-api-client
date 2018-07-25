<?php

namespace spec\Inviqa\Emarsys\Api\Response;

use Inviqa\Emarsys\Api\Response\AccountsResponse;
use PhpSpec\ObjectBehavior;

class AccountsResponseSpec extends ObjectBehavior
{
    function it_should_build_an_accounts_response_class()
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

        $accountsResponse = AccountsResponse::fromJson($json);
        $accountsResponse->getReplyCode()->shouldBe(0);
        $accountsResponse->getReplyText()->shouldBe("OK");
        $accountsResponse->getJsonEncodedData()->shouldBe('  "data": {
    "environment": "suite.emarsys.com",
    "timezone": "America/New_York",
    "name": "Heimdall",
    "password_history_queue_size": 3,
    "country": "United States of America"
  }');
    }
//
//    function it_should_throw_exception_when_data_is_missing()
//    {
//        $json = <<< 'EOD'
//{
//  "replyText": "OK",
//  "data": {
//    "environment": "suite.emarsys.com",
//    "timezone": "America/New_York",
//    "name": "Heimdall",
//    "password_history_queue_size": 3,
//    "country": "United States of America"
//  }
//}
//EOD;
//        $this->shouldThrow(new \InvalidArgumentException('Cannot instantiate Emarsys Accounts Response object because of the replyCode is missing from the response'))->duringProvide($json);
//
//        $json = <<< 'EOD'
//{
//  "replyCode": "0",
//  "data": {
//    "environment": "suite.emarsys.com",
//    "timezone": "America/New_York",
//    "name": "Heimdall",
//    "password_history_queue_size": 3,
//    "country": "United States of America"
//  }
//}
//EOD;
//        $this->shouldThrow(new \InvalidArgumentException('Cannot instantiate Emarsys Accounts Response object because of the replyText is missing from the response'))->duringProvide($json);
//    }
//
//    function it_should_throw_an_exception_when_the_json_cannot_be_decoded()
//    {
//        $json = "";
//
//        $this->shouldThrow(new \InvalidArgumentException('Cannot instantiate Emarsys Accounts Response object due to an empty response body'))->duringProvide($json);
//    }
}
