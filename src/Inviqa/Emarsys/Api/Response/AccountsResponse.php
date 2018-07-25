<?php

namespace Inviqa\Emarsys\Api\Response;

class AccountsResponse
{
    private const JSON_DECODING_ARRAY_FORMAT = true;

    private $replyCode;

    private $replyText;

    private $data;

    private function __construct()
    {
    }

    public static function fromClientResponse(ClientResponse $clientResponse): self
    {
        $instance = new self();
        $response = json_decode($clientResponse->getBodyContents(), self::JSON_DECODING_ARRAY_FORMAT);
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

    public function getJsonEncodedData(): array
    {
        return $this->data;
    }

    public function isSuccessful(): bool
    {
        return $this->replyCode == "0";
    }

    /**
     * @param mixed $response
     *
     * @throws \InvalidArgumentException
     */
    private function validate($response)
    {
        if (!is_array($response)) {
            throw new \InvalidArgumentException('Cannot instantiate Emarsys Accounts Response object due to an empty response body');
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
                sprintf('Cannot instantiate Emarsys Accounts Response object because of the %s is missing from the response', $fieldName)
            );
        }
    }
}
