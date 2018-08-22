@emarsys
Feature: Ensure contacts are sent to Emarsys via the REST API
  As a store owner
  I want new customer data to be sent to Emarsys via the API

  Scenario: Sending a new customer to Emarsys
    When I make a new customer API call with the following details
      | firstName | lastName | email                   |
      | Test      | Customer | test.customer@behat.com |
    Then I should receive a successful response from the contact endpoint
