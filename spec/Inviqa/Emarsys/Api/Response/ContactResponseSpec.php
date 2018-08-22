<?php

namespace spec\Inviqa\Emarsys\Api\Response;

use Inviqa\Emarsys\Api\Response\ClientResponse;
use PhpSpec\ObjectBehavior;

class ContactResponseSpec extends ObjectBehavior
{
    function it_should_return_a_valid_contact_response(ClientResponse $clientResponse)
    {
        $json = <<< 'EOD'
{
    "replyCode": 0,
    "replyText": "OK",
    "data": {
        "ids": [
            952758003
        ]
    }
}
EOD;
        $clientResponse->getBodyContents()->willReturn($json);
        $clientResponse->isSuccessful()->willReturn(true);
        $this->beConstructedFromClientResponse($clientResponse);

        $this->isSuccessful()->shouldBe(true);
    }

    function it_throws_an_exception_when_the_response_is_not_successful(ClientResponse $clientResponse)
    {
        $json = <<< 'EOD'
{
    "replyText": "OK",
    "data": {
        "ids": [
            952758003
        ]
    }
}
EOD;
        $clientResponse->getBodyContents()->willReturn($json);
        $clientResponse->isSuccessful()->willReturn(false);
        $clientResponse->getStatusCode()->willReturn(401);
        $clientResponse->getReasonPhrase()->willReturn('Unauthorized');
        $this->beConstructedFromClientResponse($clientResponse);

        $exception = new \LogicException(
            'Cannot instantiate Emarsys Contact Response object because of the replyCode is missing from the response'
        );

        $this->shouldThrow($exception)->duringInstantiation();
    }
}
