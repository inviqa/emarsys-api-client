# Emarsys API Client

[ ![Codeship Status for inviqa/emarsys-api-client](https://app.codeship.com/projects/d2f3dfd0-7232-0136-406f-7ede2a2ff8c2/status?branch=master)](https://app.codeship.com/projects/299368)

The purpose of this library is to abstract [Emarsys](https://www.emarsys.com/en/) API requests.

## Supported API requests and planned features
- [x] `/v2/settings`
- [x] `/sales-data/api`

## How to send CSV order data via the Sales API

#### Create a class that implements the `Inviqa\Emarsys\Api\Configuration` interface. See example below:
```php
class MyConfig implements Inviqa\Emarsys\Api\Configuration
{
    public function isTestMode(): bool
    {
        return false;
    }

    public function getEndPointUrl(): string
    {
        return "<insert_value_here>";
    }

    public function getSalesEndPointUrl(): string
    {
        return "<insert_value_here>";
    }

    public function getUsername(): string
    {
        return "<insert_value_here>";
    }

    public function getSecret(): string
    {
        return "<insert_value_here>";
    }

    public function getBearerToken(): string
    {
        return "<insert_value_here>";
    }

    public function getMerchantCode(): string
    {
        return "<insert_value_here>";
    }
}
````

#### Instantiate the library application class and inject an instance of the above configuration
```php
$app = new Inviqa\Emarsys\Application(
    new MyConfig()
);
```

#### Send the transaction data as a CSV string
```php
$transactions = file_get_contents("/path/to/orders.csv");

$salesResponse = $app->sendSalesDataViaCSV($requestParams);

if ($salesResponse->isSuccessful()) {
    echo "The CSV content has been uploaded successfully to Emarsys.";
}
```

## How to run the automated test suite
```bash
bin/phpspec r
bin/behat -s domain
```
