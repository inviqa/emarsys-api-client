<?php

use Behat\Behat\Context\Context;
use Inviqa\Emarsys\Api\Response\AccountsResponse;
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

        Assert::eq($this->response->getReplyCode(), 0);
        Assert::eq($this->response->getReplyText(), 'OK');
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

        Assert::eq($this->response->getStatusCode(), 200);
    }
}
