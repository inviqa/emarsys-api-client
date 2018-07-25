<?php

namespace Inviqa\Emarsys\Api\Response;

class SalesResponse
{
    private $isSuccessful;

    private function __construct()
    {
    }

    public static function fromClientResponse(ClientResponse $response): self
    {
        $instance = new self();
        $instance->validate($response);

        $instance->isSuccessful = $response->isSuccessful();

        return $instance;
    }

    public function isSuccessful()
    {
        return $this->isSuccessful;
    }

    private function validate(ClientResponse $response)
    {
        if (!$response->isSuccessful()) {
            throw new \LogicException(
                sprintf(
                    'Cannot instantiate Sales Response object due an error in the request (Message: %s, Code: %s).',
                    $response->getReasonPhrase(),
                    $response->getStatusCode()
                )
            );
        }
    }
}
