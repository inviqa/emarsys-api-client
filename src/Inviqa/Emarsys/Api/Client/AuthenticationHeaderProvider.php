<?php

namespace Inviqa\Emarsys\Api\Client;

use Inviqa\Emarsys\Api\Configuration;

class AuthenticationHeaderProvider
{
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function settingsAuthenticationHeader()
    {
        $nonce = bin2hex(random_bytes(32));
        $user = $this->configuration->getUsername();
        $secret = $this->configuration->getSecret();

        $timestamp = gmdate('c');
        $passwordDigest = base64_encode(sha1($nonce . $timestamp . $secret, false));

        return sprintf(
            'UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"',
            $user,
            $passwordDigest,
            $nonce,
            $timestamp
        );
    }

    public function salesAuthenticationHeader()
    {
        $bearerToken = $this->configuration->getBearerToken();

        return sprintf(
            'Bearer %s',
            $bearerToken
        );
    }
}
