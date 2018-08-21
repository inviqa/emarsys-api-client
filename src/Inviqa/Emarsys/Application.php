<?php

namespace Inviqa\Emarsys;

use Inviqa\Emarsys\Api\AccountsSettingsProvider;
use Inviqa\Emarsys\Api\Client\AuthenticationHeaderProvider;
use Inviqa\Emarsys\Api\Client\ClientFactory;
use Inviqa\Emarsys\Api\Configuration;
use Inviqa\Emarsys\Api\Request\NewContactRequest;
use Inviqa\Emarsys\Api\SalesCsvUploadProvider;

class Application
{
    private $accountSettingsProvider;
    private $salesCsvUploadProvider;
    private $newContactRequest;

    public function __construct(Configuration $configuration)
    {
        $authenticationHeaderProvider = new AuthenticationHeaderProvider($configuration);
        $clientFactory = new ClientFactory($authenticationHeaderProvider, $configuration);
        $client = $clientFactory->buildClient();

        $this->accountSettingsProvider = new AccountsSettingsProvider($client);
        $this->salesCsvUploadProvider = new SalesCsvUploadProvider($client);
        $this->newContactRequest = new NewContactRequest($client);
    }

    public function retrieveAccountSettings()
    {
        return $this->accountSettingsProvider->fetchAccountSettings();
    }

    /**
     * @throws \LogicException
     */
    public function sendSalesDataViaCSV(string $csvContent)
    {
        return $this->salesCsvUploadProvider->sendCsvContent($csvContent);
    }

    /**
     * @throws \LogicException
     */
    public function addContact(array $contactContent)
    {
        return $this->newContactRequest->addContact($contactContent);
    }
}
