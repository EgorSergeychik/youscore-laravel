# YouScore Laravel SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/egorsergeychik/youscore-laravel.svg?style=flat-square)](https://packagist.org/packages/egorsergeychik/youscore-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/egorsergeychik/youscore-laravel.svg?style=flat-square)](https://packagist.org/packages/egorsergeychik/youscore-laravel)
[![PHP Version Require](https://poser.pugx.org/egorsergeychik/youscore-laravel/require/php)](https://packagist.org/packages/egorsergeychik/youscore-laravel)

An unofficial Laravel SDK for [YouScore.com.ua](https://youscore.com.ua) - a comprehensive business intelligence platform providing detailed company information, risk analysis, and financial monitoring for Ukrainian businesses.

## Features

- 🔄 **Automatic Polling**: Built-in retry mechanism for pending API responses
- 🎭 **Laravel Integration**: Seamless integration with Laravel's service container and facades
- ⚡ **Type Safety**: Full PHP 8.1+ type hints and return types

## Requirements

- PHP 8.1 or higher
- Laravel 11.0 or higher
- YouScore API key from [youscore.com.ua](https://youscore.com.ua)

## Installation

Install the package via Composer:

```bash
composer require egorsergeychik/youscore-laravel
```

### Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=youscore-config
```

Add your YouScore API credentials to your `.env` file:

```env
YOUSCORE_API_KEY=your_api_key_here
YOUSCORE_BASE_URL=https://api.youscore.com.ua
YOUSCORE_TIMEOUT=30

# Polling configuration (optional)
YOUSCORE_POLLING_ENABLED=true
YOUSCORE_POLLING_MAX_ATTEMPTS=2
YOUSCORE_POLLING_DELAY=2500
```

## Usage

### Using the Facade

The easiest way to use the SDK is through the `YouScore` facade:

```php
use EgorSergeychik\YouScore\Facades\YouScore;

// Get company registration data
$response = YouScore::registrationData()->getUnitedStateRegisterData('39404434');

// Access response data
$companyName = $response->json('name.fullName');
$status = $response->json('status');
```

### Using Dependency Injection

You can also inject the `Client` class directly:

```php
use EgorSergeychik\YouScore\Client;

class CompanyService
{
    public function __construct(private Client $youScore)
    {
    }

    public function getCompanyData(string $code): array
    {
        $response = $this->youScore->registrationData()
            ->getUnitedStateRegisterData($code);
            
        return $response->json();
    }
}
```

## Response Handling

All methods return Laravel's `Illuminate\Http\Client\Response` object:

```php
$response = YouScore::registrationData()->getUnitedStateRegisterData('39404434');

// Check if request was successful
if ($response->successful()) {
    // Get JSON data
    $data = $response->json();
    
    // Access specific fields
    $companyName = $response->json('name.fullName');
    $status = $response->json('status');
    
    // Get raw response body
    $body = $response->body();
    
    // Get status code
    $statusCode = $response->status();
}

// Handle errors
if ($response->failed()) {
    $errorMessage = $response->json('message', 'Unknown error occurred');
    // Handle error appropriately
}
```

## Automatic Polling

The SDK includes automatic polling for handling pending API responses (HTTP 202):

```php
// The SDK will automatically retry requests that return 202 status
$response = YouScore::registrationData()->getUnitedStateRegisterData('39404434');
// Will retry up to max_attempts times with specified delay
```

Configure polling behavior in your `config/youscore.php`:

```php
'polling' => [
    'enabled' => true,        // Enable/disable polling
    'max_attempts' => 2,      // Maximum retry attempts
    'delay' => 2500,          // Delay between attempts (milliseconds)
],
```

## Error Handling

The SDK automatically throws exceptions for HTTP errors. You can catch and handle them:

```php
use Illuminate\Http\Client\RequestException;

try {
    $response = YouScore::registrationData()->getUnitedStateRegisterData('invalid_code');
} catch (RequestException $e) {
    // Handle HTTP errors (4xx, 5xx)
    $statusCode = $e->response->status();
    $errorBody = $e->response->body();
    
    Log::error('YouScore API error', [
        'status' => $statusCode,
        'response' => $errorBody,
    ]);
}
```

## Configuration Options

The package supports various configuration options in `config/youscore.php`:

```php
return [
    // API endpoint (usually doesn't need to be changed)
    'base_url' => env('YOUSCORE_BASE_URL', 'https://api.youscore.com.ua'),
    
    // Your YouScore API key
    'api_key' => env('YOUSCORE_API_KEY', ''),
    
    // Request timeout in seconds
    'timeout' => env('YOUSCORE_TIMEOUT', 30),

    // Polling configuration for handling 202 responses
    'polling' => [
        'enabled' => env('YOUSCORE_POLLING_ENABLED', true),
        'max_attempts' => env('YOUSCORE_POLLING_MAX_ATTEMPTS', 2),
        'delay' => env('YOUSCORE_POLLING_DELAY', 2500), // milliseconds
    ],
];
```

## Testing

Run the package tests:

```bash
composer test
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Security

If you discover any security-related issues, please email sergeychike.egor@gmail.com instead of using the issue tracker.


## Disclaimer

This is an unofficial SDK for YouScore.com.ua. It is not affiliated with, endorsed by, or sponsored by YouScore. Use at your own risk.

