<?php

namespace Inviqa\Emarsys\Api\Response;

class ContactResponse
{
    private $isSuccessful;

    /**
     * @throws \LogicException
     */
    public static function fromClientResponse(ClientResponse $response): self
    {
        $instance = new self();

        $instance->isSuccessful = $response->isSuccessful();
        $instance->validate($response);

        return $instance;
    }

    public function isSuccessful()
    {
        return $this->isSuccessful;
    }

    /**
     * @throws \LogicException
     */
    private function validate(ClientResponse $response)
    {
        if (!$response->isSuccessful()) {
            throw new \LogicException(
                sprintf(
                    'Cannot instantiate Client Response object due an error in the request (Message: %s, Code: %s).',
                    $response->getReasonPhrase(),
                    $response->getStatusCode()
                )
            );
        }
    }
}
