# Validation record

Validated locally on 16 October 2026. All HTTP calls in the test suite are simulated. No live merchant credentials or payment transactions were used.

- 84 response aliases are declared on existing SDK classes; response placeholder classes have been removed.
- 90 PHPStan type assertions in response inference fixtures cover all 58 fluent entry points and both callback verification methods.
- 58 concrete operations are mapped to documented actions and destinations in the endpoint fixtures.
- 365 tests / 1,740 assertions cover operation payloads, field types, required fields, funding alternatives, signing, callbacks, configuration and response handling.
- PHP 8.5.0: `composer check` (tests, PHPStan maximum level, formatting).
- PHP 8.2.34: full test suite with latest compatible dependencies, then `composer check` with the lowest dependency versions allowed by Composer.
- PHP CS Fixer uses Laravel Pint's Laravel preset; 174 files were reformatted and all PHP files pass the style check on PHP 8.2 and 8.5.
- Composer metadata: `composer validate --strict --no-check-lock`.
- GitHub Actions configures PHP 8.2, 8.3, 8.4 and 8.5, plus the PHP 8.2 lowest-dependency job. PHP 8.3/8.4 have not been run locally.

| Environment | Guzzle | PHPUnit | PHPStan |
| --- | --- | --- | --- |
| PHP 8.5 (latest compatible dependencies) | 7.15.5 | 11.5.57 | 2.3.1 |
| PHP 8.2 (lowest allowed dependencies) | 7.15.2 | 11.5.50 | 2.3.1 |

The Composer lock is intentionally ignored by Git for this library. The local checkout contains installed development dependencies so `composer check` can run immediately. Consumer applications resolve and lock their own versions.
