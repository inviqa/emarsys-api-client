<?php

namespace Inviqa\Emarsys\Api\Response;

use Psr\Http\Message\ResponseInterface;

class SalesResponse
{
    private $statusCode;

    private $statusText;

    private function __construct()
    {
    }

    public static function fromHttpResponse(ResponseInterface $response): self
    {
        $instance = new self();
        $instance->validate($response);

        $instance->statusCode = $response->getStatusCode();
        $instance->statusText = $response->getReasonPhrase();

        return $instance;
    }

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    public function getStatusText(): string
    {
        return $this->statusText;
    }

    private function validate(ResponseInterface $response)
    {
        if ($response->getStatusCode() != '200') {
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
