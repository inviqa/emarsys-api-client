<?php

namespace spec\Inviqa\Emarsys\Api\Response;

use Inviqa\Emarsys\Api\Response\ClientResponse;
use PhpSpec\ObjectBehavior;

class SalesResponseSpec extends ObjectBehavior
{
    function it_should_return_a_valid_sales_response(ClientResponse $clientResponse)
    {
        $clientResponse->isSuccessful()->willReturn(true);
        $this->beConstructedFromClientResponse($clientResponse);

        $this->isSuccessful()->shouldBe(true);
    }

    function it_throws_an_exception_when_the_response_is_not_successful(ClientResponse $clientResponse)
    {
        $clientResponse->isSuccessful()->willReturn(false);
        $clientResponse->getStatusCode()->willReturn(401);
        $clientResponse->getReasonPhrase()->willReturn('Unauthorized');
        $this->beConstructedFromClientResponse($clientResponse);

        $exception = new \LogicException(
            'Cannot instantiate Sales Response object due an error in the request (Message: Unauthorized, Code: 401).'
        );

        $this->shouldThrow($exception)->duringInstantiation();
    }
}
