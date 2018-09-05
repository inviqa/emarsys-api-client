@emarsys
Feature: Ensure contacts are sent to Emarsys via the REST API
    As a store owner
    I want new customer data to be sent to Emarsys via the API

    Scenario: Sending a new customer to Emarsys
        When I make a new customer API call with the following details
            | customerNumber | firstName | lastName | email                   | dob        | gender | city    | postcode | country | reiss_country  | channel | phone        | optIn | contactSource | contactSourceDetail | registrationDate | newsletter | vip |
            | 123456         | Test      | Customer | test.customer@behat.com | 1979-05-21 | 1      | Glasgow | PA16 0XA | 184     | United Kingdom | UK      | 01475 631514 | 1     | web           | Register            | 2009-01-25       | mens       | Y   |
        Then I should receive a successful response from the contact endpoint

    Scenario: Receiving an error response from Emarsys
        When I make a new customer API call with the following details
            | customerNumber | firstName | lastName | email                   | dob        | gender | city    | postcode | country  | reiss_country  | channel | phone        | optIn | contactSource | contactSourceDetail | registrationDate | newsletter | vip |
            | 123456         | Test      | Customer | test.customer@behat.com | 1979-05-21 | 1      | Glasgow | PA16 0XA | hasError | United Kingdom | UK      | 01475 631514 | 1     | web           | Register            | 2009-01-25       | mens       | Y   |
        Then I should receive a successful response from the endpoint that has an error message
