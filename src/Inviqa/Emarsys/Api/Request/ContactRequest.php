<?php

namespace Inviqa\Emarsys\Api\Request;

use Inviqa\Emarsys\Api\Client;
use Inviqa\Emarsys\Api\Response\ContactResponse;

class ContactRequest
{
    private const CUSTOMER_NUMBER = 1188;
    private const FIRST_NAME = 1;
    private const LAST_NAME = 2;
    private const EMAIL_ADDRESS = 3;
    private const DOB = 4;
    private const GENDER = 5;
    private const CITY = 11;
    private const ZIP_CODE = 13;
    private const COUNTRY = 14;
    private const REISS_COUNTRY = 6096;
    private const CHANNEL = 6049;
    private const PHONE = 15;
    private const OPT_IN = 31;
    private const REGISTRATION_SOURCE = 6092;
    private const REGISTRATION_DETAIL = 6093;
    private const REGISTRATION_DATE = 6097;
    private const REISS_NEWSLETTER = 6094;
    private const STORE_VIP = 6095;

    private $client;

    private static $map = [
        self::CUSTOMER_NUMBER,
        self::FIRST_NAME,
        self::LAST_NAME,
        self::EMAIL_ADDRESS,
        self::DOB,
        self::GENDER,
        self::CITY,
        self::ZIP_CODE,
        self::COUNTRY,
        self::REISS_COUNTRY,
        self::CHANNEL,
        self::PHONE,
        self::OPT_IN,
        self::REGISTRATION_SOURCE,
        self::REGISTRATION_DETAIL,
        self::REGISTRATION_DATE,
        self::REISS_NEWSLETTER,
        self::STORE_VIP,
    ];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \LogicException
     */
    public function addOrUpdateContact(array $contactContent): ContactResponse
    {
        $contacts = array_combine(self::$map, $contactContent);
        $contacts = array_filter($contacts, function($value) { return $value !== ''; });

        $body = [
            'key_id' => self::CUSTOMER_NUMBER,
            'contacts' => [
                $contacts
            ]
        ];

        return ContactResponse::fromClientResponse($this->client->addOrUpdateContact($body));
    }
}
