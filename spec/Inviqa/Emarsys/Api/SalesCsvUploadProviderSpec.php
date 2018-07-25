<?php

namespace spec\Inviqa\Emarsys\Api;

use Inviqa\Emarsys\Api\Client;
use Inviqa\Emarsys\Api\Response\ClientResponse;
use Inviqa\Emarsys\Api\Response\SalesResponse;
use PhpSpec\ObjectBehavior;

class SalesCsvUploadProviderSpec extends ObjectBehavior
{
    const CSV_CONTENT = "some_csv,mcontent";

    function let(Client $client)
    {
        $this->beConstructedWith($client);
    }

    function it_returns_a_sales_response(Client $client, ClientResponse $clientResponse)
    {
        $client->sendCSVContent(self::CSV_CONTENT)->willReturn($clientResponse);
        $clientResponse->isSuccessful()->willReturn(true);

        $this->sendCsvContent(self::CSV_CONTENT)->shouldBeLike(
            SalesResponse::fromClientResponse($clientResponse->getWrappedObject())
        );
    }
}
