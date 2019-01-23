# Lumio integrations api php client

## Requirements

PHP 5.5 or later

## Installation & Usage
### Composer

To install the bindings via [Composer](http://getcomposer.org/), run `composer require lumioanalytics/lia-php-client`

### Manual Installation

Download the files and include `autoload.php`:

```php
    require_once('/path/to/lia-php-client/vendor/autoload.php');
```

## Tests

To run the unit tests:

```
composer install
./vendor/bin/phpunit
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$client = new Lumio\IntegrationAPI\Client();
$integration = new Lumio\IntegrationAPI\Model\Integration([
	'key'              => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
	'url'              => 'https://example.com/',
	'platform'         => 'WordPress',
	'platform_version' => '4.5.6',
	'plugin'           => 'wp-lumio-analytics',
	'plugin_version'   => '0.0.1',
	'status'           => 'active'
]);

try {
    $result = $client->registerIntegration($integration);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AdminsApi->getAll: ', $e->getMessage(), PHP_EOL;
}

?>
```

## Documentation for API Endpoints

All URIs are relative to *https://api.lumio.page/*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*DevelopersApi* | [**save**](docs/Api/DevelopersApi.md#save) | **POST** /integration | adds an integration item


## Author

mikel@tiralineasestudio.com
