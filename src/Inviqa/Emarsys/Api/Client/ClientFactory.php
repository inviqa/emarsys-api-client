<?php

namespace Inviqa\Emarsys\Api\Client;

use Inviqa\Emarsys\Api\Client;
use Inviqa\Emarsys\Api\Configuration;
use test\Inviqa\Emarsys\TestClient;

class ClientFactory
{
    private $authenticationHeaderProvider;
    private $configuration;

    public function __construct(
        AuthenticationHeaderProvider $authenticationHeaderProvider,
        Configuration $configuration
    ) {
        $this->authenticationHeaderProvider = $authenticationHeaderProvider;
        $this->configuration = $configuration;
    }

    public function buildClient(): Client
    {
        if ($this->configuration->isTestMode()) {
            return new TestClient();
        }

        return new HttpClient($this->authenticationHeaderProvider, $this->configuration);
    }
}
