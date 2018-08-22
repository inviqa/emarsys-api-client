<?php

namespace spec\Inviqa\Emarsys\Api\Request;

use Inviqa\Emarsys\Api\Client;
use Inviqa\Emarsys\Api\Response\ClientResponse;
use Inviqa\Emarsys\Api\Response\ContactResponse;
use PhpSpec\ObjectBehavior;

class NewContactRequestSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client);
    }

    function it_returns_a_contact_response(Client $client, ClientResponse $clientResponse)
    {
        $contactContent = [
            1 => 'test',
            2 => 'customer',
            3 => 'test@customer.com'
        ];

        $body = [
            'key_id' => '3', // This defaults to 3 (email) if not set, but setting anyway
            'contacts' => [$contactContent]
        ];

        $client->addContact($body)->willReturn($clientResponse);
        $clientResponse->isSuccessful()->willReturn(true);

        $this->addContact($contactContent)->shouldBeLike(
            ContactResponse::fromClientResponse($clientResponse->getWrappedObject())
        );
    }
}
