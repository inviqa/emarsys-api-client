<?php

namespace Inviqa\Emarsys;

use Inviqa\Emarsys\Api\AccountsSettingsProvider;
use Inviqa\Emarsys\Api\Client\AuthenticationHeaderProvider;
use Inviqa\Emarsys\Api\Client\ClientFactory;
use Inviqa\Emarsys\Api\Configuration;
use Inviqa\Emarsys\Api\Request\ContactRequest;
use Inviqa\Emarsys\Api\SalesCsvUploadProvider;

class Application
{
    private $accountSettingsProvider;
    private $salesCsvUploadProvider;
    private $contactRequest;

    public function __construct(Configuration $configuration)
    {
        $authenticationHeaderProvider = new AuthenticationHeaderProvider($configuration);
        $clientFactory = new ClientFactory($authenticationHeaderProvider, $configuration);
        $client = $clientFactory->buildClient();

        $this->accountSettingsProvider = new AccountsSettingsProvider($client);
        $this->salesCsvUploadProvider = new SalesCsvUploadProvider($client);
        $this->contactRequest = new ContactRequest($client, $configuration->getKeyFieldId());
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
    public function addOrUpdateContact(array $contactContent)
    {
        return $this->contactRequest->addOrUpdateContact($contactContent);
    }

    /**
     * @throws \LogicException
     */
    public function deleteContact(int $customerIdentifier)
    {
        return $this->contactRequest->deleteContact($customerIdentifier);
    }
}
