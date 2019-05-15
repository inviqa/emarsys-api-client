<?php

namespace Inviqa\Emarsys\Api;

use Inviqa\Emarsys\Api\Response\ClientResponse;

interface Client
{
    public function sendCSVContent(string $csvFileAbsolutePath): ClientResponse;

    public function requestAccountSettings(): ClientResponse;

    public function addOrUpdateContact(array $contactContent): ClientResponse;

    public function deleteContact(array $contactContent): ClientResponse;

        public function optOutContact(array $contactContent): ClientResponse;
}
