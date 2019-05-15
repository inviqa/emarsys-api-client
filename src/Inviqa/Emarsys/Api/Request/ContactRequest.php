<?php

namespace Inviqa\Emarsys\Api\Request;

use Inviqa\Emarsys\Api\Client;
use Inviqa\Emarsys\Api\Response\ContactResponse;

class ContactRequest
{
    private $client;
    private $keyFieldId;

    public function __construct(Client $client, int $keyFieldId)
    {
        $this->client = $client;
        $this->keyFieldId = $keyFieldId;
    }

    /**
     * @throws \LogicException
     */
    public function addOrUpdateContact(array $contactContent, array $allowEmpty = []): ContactResponse
    {
        $contacts = array_filter($contactContent, function ($value, $key) use ($allowEmpty) {
            return $value !== '' || in_array($key, $allowEmpty);
        }, ARRAY_FILTER_USE_BOTH);


        $body = [
            'key_id' => $this->keyFieldId,
            'contacts' => [
                $contacts,
            ],
        ];

        return ContactResponse::fromClientResponse($this->client->addOrUpdateContact($body));
    }

    public function deleteContact(int $customerIdentifier)
    {
        $body = [
            $this->keyFieldId => $customerIdentifier,
            'key_id' => $this->keyFieldId,
        ];

        return ContactResponse::fromClientResponse($this->client->deleteContact($body));
    }

    public function optOutContact(array $contactContent)
    {
        return ContactResponse::fromClientResponse($this->client->optOutContact($contactContent));
    }
}
