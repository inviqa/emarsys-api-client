<?php

namespace spec\Inviqa\Emarsys\Api\Response\Sales;

use GuzzleHttp\Psr7\Response;
use Inviqa\Emarsys\Api\Response\Sales\SalesResponse;
use PhpSpec\ObjectBehavior;

class SalesResponseProviderSpec extends ObjectBehavior
{
    private const RESPONSE_HEADERS = [];

    private const RESPONSE_BODY = null;

    private const RESPONSE_HTTP_VERSION = '1.1';

    function it_should_build_a_sales_response_class()
    {
        $response = new Response('200', self::RESPONSE_HEADERS, self::RESPONSE_BODY, self::RESPONSE_HTTP_VERSION, 'OK');
        $requestResponse = new SalesResponse('200', 'OK');
        $this->provide($response)->shouldBeLike($requestResponse);
    }

    function it_should_throw_exception_during_a_not_successful_response()
    {
        $response = new Response('400', self::RESPONSE_HEADERS, self::RESPONSE_BODY, self::RESPONSE_HTTP_VERSION, 'Authorization issue');
        $this->shouldThrow(new \LogicException('Cannot instantiate Sales Response object due an error in the request (Message: Authorization issue, Code: 400).'))->duringProvide($response);
    }
}
