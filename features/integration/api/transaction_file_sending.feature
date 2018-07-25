@emarsys
Feature: Ensure transaction CSVs are send to Emarsys via the sales API
    In order to send the sales transactions to Emarsys
    I need to send CSV files to Emarsys via the sales API

    Scenario: Sending a transaction file to Emarsys via the Sales API
        When I send a CSV content to Emarsys
        Then I should receive a successful response from the Sales endpoint
