<?php

namespace Inviqa\Emarsys;

use Inviqa\Emarsys\Api\AccountsSettingsProvider;
use Inviqa\Emarsys\Api\Client\AuthenticationHeaderProvider;
use Inviqa\Emarsys\Api\Client\ClientFactory;
use Inviqa\Emarsys\Api\Configuration;
use Inviqa\Emarsys\Api\SalesCsvUploadProvider;

class Application
{
    private $accountSettingsProvider;
    private $salesCsvUploadProvider;

    public function __construct(Configuration $configuration)
    {
        $authenticationHeaderProvider = new AuthenticationHeaderProvider($configuration);
        $clientFactory = new ClientFactory($authenticationHeaderProvider, $configuration);
        $client = $clientFactory->buildClient();

        $this->accountSettingsProvider = new AccountsSettingsProvider($client);
        $this->salesCsvUploadProvider = new SalesCsvUploadProvider($client);
    }

    public function retrieveAccountSettings()
    {
        return $this->accountSettingsProvider->fetchAccountSettings();
    }

    public function sendSalesDataViaCSV(string $csvContent)
    {
        return $this->salesCsvUploadProvider->sendCsvContent($csvContent);
    }
}
