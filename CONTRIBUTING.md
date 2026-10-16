# Contributing

Bug reports, documentation fixes and pull requests are welcome.

## Development setup

```bash
git clone https://github.com/andriichuk/liqpay-php-sdk.git
cd liqpay-php-sdk
composer install
composer format
composer check
```

The SDK requires PHP 8.2+. PHPStan 2.3.1+ parses the inline comments in response shapes. PHP CS Fixer applies the Laravel preset. CI checks PHP 8.2–8.5 and the lowest supported dependencies on PHP 8.2.

## Changes to API operations

Link to the relevant LiqPay API documentation. Keep each operation in a concrete request class and preserve native response values. Response shapes belong in PHPDoc on the existing SDK classes.

For a new or changed operation, update the endpoint fixtures, request validation, field documentation, response shape and static inference fixtures as appropriate. Run `composer check` before opening a pull request. Tests must use simulated HTTP and documented test data.

## Pull requests

Describe the problem, resulting behavior and validation. Keep unrelated changes in separate pull requests. New contributions are licensed under this project's MIT license.

For security reports, follow [SECURITY.md](SECURITY.md). For other issues, include the PHP/package versions and a minimal reproduction without credentials or customer payment data.
