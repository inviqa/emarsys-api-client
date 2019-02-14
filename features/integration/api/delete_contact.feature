@emarsys
Feature: Ensure contacts can be deleted from Emarsys via the REST API
    As a store owner
    I want to be able to delete customers from Emarsys via the API

    Scenario: Deleting a customer
        When I make a delete customer API call with the customer number 3550925
        Then I should receive a successful response from the contact endpoint

    Scenario: Deleting a customer
        When I make a delete customer API call with the customer number 999
        Then I should receive a successful response from the endpoint that has an error message
