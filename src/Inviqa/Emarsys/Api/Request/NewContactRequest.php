<?php

namespace Inviqa\Emarsys\Api\Request;

use Inviqa\Emarsys\Api\Client;
use Inviqa\Emarsys\Api\Response\ContactResponse;

class NewContactRequest
{
    private $client;

    private static $map = [
        1, // First name
        2, // Last name
        3, // email
    ];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \LogicException
     */
    public function addContact(array $contactContent): ContactResponse
    {
        $body = [
            'key_id' => '3', // This defaults to 3 (email) if not set, but setting anyway
            'contacts' => [
                array_combine(self::$map, $contactContent)
            ]
        ];

        return ContactResponse::fromClientResponse($this->client->addContact($body));
    }
}
