<?php

namespace Inviqa\Emarsys\Api\Request;

use Inviqa\Emarsys\Api\Client;
use Inviqa\Emarsys\Api\Response\ContactResponse;

class NewContactRequest
{
    private const FIRST_NAME = 1;
    private const LAST_NAME = 2;
    private const EMAIL_ADDRESS = 3;

    private $client;

    private static $map = [
        self::FIRST_NAME,
        self::LAST_NAME,
        self::EMAIL_ADDRESS,
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
            'key_id' => self::EMAIL_ADDRESS, // This defaults to 3 (email) if not set, but setting anyway
            'contacts' => [
                array_combine(self::$map, $contactContent)
            ]
        ];

        return ContactResponse::fromClientResponse($this->client->addContact($body));
    }
}
