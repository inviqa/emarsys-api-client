<?php

namespace Inviqa\Emarsys\Api\Response;

class ContactResponse
{
    /**
     * @throws \LogicException
     */
    public static function fromClientResponse(ClientResponse $clientResponse): self
    {
        $instance = new self();
        $response = json_decode($clientResponse->getBodyContents(), true);

        $instance->validate($response);

        $instance->replyCode = $response['replyCode'];
        $instance->replyText = $response['replyText'];
        $instance->data = $response['data'];

        return $instance;
    }

    public function getReplyCode(): string
    {
        return $this->replyCode;
    }

    public function getReplyText(): string
    {
        return $this->replyText;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function isSuccessful(): bool
    {
        return $this->replyCode == "0";
    }

    public function hasErrors()
    {
        return isset($this->data['errors']);
    }

    public function getErrors()
    {
        return $this->data['errors'];
    }

    /**
     * @param mixed $response
     *
     * @throws \InvalidArgumentException
     */
    private function validate($response)
    {
        if (!is_array($response)) {
            throw new \InvalidArgumentException('Cannot instantiate Emarsys Contact Response object due to an empty response body');
        }

        $fieldsToValidate = ['replyCode', 'replyText'];

        foreach ($fieldsToValidate as $fieldName) {
            $this->validateField($response, $fieldName);
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function validateField(array $response, string $fieldName)
    {
        if (!array_key_exists($fieldName, $response)) {
            throw new \InvalidArgumentException(
                sprintf('Cannot instantiate Emarsys Contact Response object because of the %s is missing from the response', $fieldName)
            );
        }
    }
}
