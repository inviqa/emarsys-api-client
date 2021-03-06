<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Emarsys\Api\Response\AccountsResponse;
use Inviqa\Emarsys\Api\Response\ContactResponse;
use Inviqa\Emarsys\Api\Response\SalesResponse;
use Inviqa\Emarsys\Application;
use Symfony\Component\Yaml\Yaml;
use test\Inviqa\Emarsys\TestConfiguration;
use Webmozart\Assert\Assert;

class ApiContext implements Context
{
    private $application;

    /**
     * @var AccountsResponse|SalesResponse
     */
    private $response;

    public function __construct(bool $testMode)
    {
        if ($testMode) {
            $configuration = new TestConfiguration();
        } else {
            $yamlConfig = Yaml::parseFile(__DIR__ . '/../../test/config/integration_config.yml');
            $yamlConfig['isTestMode'] = false;

            $configuration = new TestConfiguration($yamlConfig);
        }

        $this->application = new Application($configuration);
    }

    /**
     * @When I retrieve the account settings from the Emarsys API endpoint
     */
    public function iRetrieveTheAccountSettingsFromTheEmarsysApiEndpoint()
    {
        $this->response = $this->application->retrieveAccountSettings();
    }

    /**
     * @Then I should receive a successful response from the Settings endpoint
     */
    public function iShouldReceiveTheFollowingResponse()
    {
        Assert::isInstanceOf($this->response, AccountsResponse::class);

        Assert::true($this->response->isSuccessful());
    }

    /**
     * @When /^I send a CSV content to Emarsys$/
     */
    public function iSendACSVContentToEmarsysLike()
    {
        $csvContent = <<<'EOD'
item,	price,	order,	timestamp,	customer,	quantity
46604801010,	30.0000,	1856143,	2015-12-27T16:25:28Z, 1687099, 1
46604801011,	31.0000,	1856144,	2015-12-27T16:25:28Z,	1687199,	2
EOD;
        $this->response = $this->application->sendSalesDataViaCSV($csvContent);
    }

    /**
     * @Then /^I should receive a successful response from the Sales endpoint$/
     */
    public function iShouldReceiveASuccessfulEmarsysResponse()
    {
        Assert::isInstanceOf($this->response, SalesResponse::class);

        Assert::true($this->response->isSuccessful());
    }

    /**
     * @When I make a new customer API call with the following details
     */
    public function iMakeANewCustomerApiCallWithTheFollowingDetails(TableNode $table)
    {
        $this->response = $this->application->addOrUpdateContact($table->getHash()[0]);
    }

    /**
     * @Then I should receive a successful response from the contact endpoint
     */
    public function iShouldReceiveASuccessfulResponseFromTheContactEndpoint()
    {
        Assert::isInstanceOf($this->response, ContactResponse::class);

        Assert::true($this->response->isSuccessful());
    }

    /**
     * @Then I should receive a successful response from the endpoint that has an error message
     */
    public function iShouldReceiveASuccessfulResponseFromTheEndpointThatHasAnErrorMessage()
    {
        Assert::true($this->response->hasErrors());
    }

    /**
     * @When I make a delete customer API call with the customer number :customerNumber
     */
    public function iMakeADeleteCustomerApiCallWithTheCustomerNumber(int $customerIdentifier)
    {
        $this->response = $this->application->deleteContact($customerIdentifier);
    }

    /**
     * @When I make an opt out customer API call with the following details
     */
    public function iMakeAnOptOutCustomerApiCallWithTheFollowingDetails(TableNode $table)
    {
        $this->response = $this->application->optOutContact($table->getHash()[0]);
    }

}
