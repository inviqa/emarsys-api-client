<?php

namespace Inviqa\Emarsys\Api\Response;

use Psr\Http\Message\ResponseInterface;

class ClientResponse
{
    private $statusCode;
    private $reasonPhrase;
    private $bodyContents;

    public static function fromResponseInterface(ResponseInterface $response): self
    {
        $instance = new self();
        $instance->statusCode = $response->getStatusCode();
        $instance->reasonPhrase = $response->getReasonPhrase();
        $instance->bodyContents = (string) $response->getBody()->getContents();

        return $instance;
    }

    public function isSuccessful()
    {
        return $this->statusCode == 200;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    public function getBodyContents()
    {
        return $this->bodyContents;
    }
}
