<?php

namespace Inviqa\Emarsys\Api\Request;

use Inviqa\Emarsys\Api\Client;
use Inviqa\Emarsys\Api\Response\ContactResponse;

class NewContactRequest
{
    private const CUSTOMER_NUMBER = 1188;
    private const FIRST_NAME = 1;
    private const LAST_NAME = 2;
    private const EMAIL_ADDRESS = 3;
    private const DOB = 4;
    private const GENDER = 5;
    private const CITY = 11;
    private const POSTCODE = 13;
    private const COUNTRY = 14;
    private const REISS_COUNTRY = 6096;
    private const CHANNEL = 6049;
    private const PHONE = 15;
    private const OPT_IN = 31;
    private const REGISTRATION_SOURCE = 6092;
    private const REGISTRATION_DETAIL = 6093;
    private const REGISTRATION_DATE = 6097;
    private const NEWSLETTER = 6094;
    private const VIP = 6095;

    private $client;

    private static $map = [
        self::CUSTOMER_NUMBER,
        self::FIRST_NAME,
        self::LAST_NAME,
        self::EMAIL_ADDRESS,
        self::DOB,
        self::GENDER,
        self::CITY,
        self::POSTCODE,
        self::COUNTRY,
        self::REISS_COUNTRY,
        self::CHANNEL,
        self::PHONE,
        self::OPT_IN,
        self::REGISTRATION_SOURCE,
        self::REGISTRATION_DETAIL,
        self::REGISTRATION_DATE,
        self::NEWSLETTER,
        self::VIP,
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
            'key_id' => self::CUSTOMER_NUMBER,
            'contacts' => [
                array_combine(self::$map, $contactContent)
            ]
        ];

        return ContactResponse::fromClientResponse($this->client->addContact($body));
    }
}
