<?php

namespace spec\Inviqa\Emarsys\Api\Request;

use Inviqa\Emarsys\Api\Client;
use Inviqa\Emarsys\Api\Response\ClientResponse;
use Inviqa\Emarsys\Api\Response\ContactResponse;
use PhpSpec\ObjectBehavior;

class ContactRequestSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client, 1188);
    }

    function it_returns_a_contact_response(Client $client, ClientResponse $clientResponse)
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

        $contactContent = [
            1188 => "123456",
            1    => "Test",
            2    => "Customer",
            3    => "test.customer@behat.com",
            4    => "1979-05-21",
            5    => "1",
            11   => "Glasgow",
            13   => "PA16 0XA",
            14   => "hasError",
            6096 => "United Kingdom",
            6049 => "UK",
            15   => "01475 631514",
            31   => "1",
            6092 => "web",
            6093 => "Register",
            6097 => "2009-01-25",
            6094 => "mens",
            6095 => "Y",
        ];

        $body = [
            'key_id'   => '1188', // This defaults to 3 (email) if not set, but setting anyway
            'contacts' => [$contactContent]
        ];

        $client->addOrUpdateContact($body)->willReturn($clientResponse);
        $clientResponse->isSuccessful()->willReturn(true);
        $clientResponse->getBodyContents()->willReturn($json);

        $this->addOrUpdateContact($contactContent)->shouldBeLike(
            ContactResponse::fromClientResponse($clientResponse->getWrappedObject())
        );
    }


    function it_returns_a_contact_response_for_delete_request(Client $client, ClientResponse $clientResponse)
    {
        $json = <<< 'EOD'
{
    "replyCode":0,
    "replyText":"OK",
    "data":{
        "errors":[],
        "deleted_contacts":1
    }
}
EOD;

        $contactIdentifier = "123456";

        $body = [
            'key_id'   => '1188', // This defaults to 3 (email) if not set, but setting anyway
            'contacts' => $contactIdentifier
        ];

        $client->deleteContact($body)->willReturn($clientResponse);
        $clientResponse->isSuccessful()->willReturn(true);
        $clientResponse->getBodyContents()->willReturn($json);

        $this->addOrUpdateContact($contactIdentifier)->shouldBeLike(
            ContactResponse::fromClientResponse($clientResponse->getWrappedObject())
        );
    }
}
