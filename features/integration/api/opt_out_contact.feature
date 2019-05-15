@emarsys
Feature: Ensure contacts can be opted out of a campaign via the REST API
    As a store owner
    I want to be able to opt out customers from Emarsys via the API

    Scenario: Opt out a customer
        When I make an opt out customer API call with the following details
        | launch_list_id | email_id | contact_uid |
        | 1234           | 4321     | 1111        |
        Then I should receive a successful response from the contact endpoint

    Scenario: Opt out a customer with invalid details
        When I make an opt out customer API call with the following details
            | launch_list_id | email_id | contact_uid |
            | 1234           | 4321     | 999999      |
        Then I should receive a successful response from the endpoint that has an error message
