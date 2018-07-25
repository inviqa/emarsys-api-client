<?php

namespace spec\Inviqa\Emarsys\Api\Request\Sales;

use GuzzleHttp\Psr7\Response;
use Inviqa\Emarsys\Api\Client\Sales\Client;
use Inviqa\Emarsys\Api\Response\Sales\SalesResponse;
use Inviqa\Emarsys\Api\Response\Sales\SalesResponseProvider;
use PhpSpec\ObjectBehavior;

class SalesCsvUploadProviderSpec extends ObjectBehavior
{
    private const RESPONSE_HEADERS = [];

    private const RESPONSE_BODY = null;

    private const RESPONSE_HTTP_VERSION = '1.1';

    function let(
        SalesResponseProvider $salesResponseProvider,
        Client $client
    ) {
        $this->beConstructedWith($salesResponseProvider, $client);
    }

    function it_receives_successful_response_from_sales_data_upload_request(
        SalesResponseProvider $salesResponseProvider,
        Client $client
    ) {
        $requestResponse = new Response('200', self::RESPONSE_HEADERS, self::RESPONSE_BODY, self::RESPONSE_HTTP_VERSION, 'OK');
        $client->sendCSVContent('123')->willReturn($requestResponse);

        $response = new SalesResponse('200', 'OK');
        $salesResponseProvider->provide($requestResponse)->willReturn($response);

        $this->sendCsvContent('123')->shouldBeLike($response);
    }
}
