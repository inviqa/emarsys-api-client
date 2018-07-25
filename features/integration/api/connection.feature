@emarsys
Feature: Ensure API communication with Emarsys
    In order to communicate with the Emarsys API
    I need to make sure the connection is successful

    Scenario: Making a successfull API call
        When I retrieve the account settings from the Emarsys API endpoint
        Then I should receive a successful response from the Settings endpoint
