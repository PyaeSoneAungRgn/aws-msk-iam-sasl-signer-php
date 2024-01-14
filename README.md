# AWS MSK IAM SASL Signer for PHP 

`aws-msk-iam-sasl-signer-php` is the AWS MSK IAM SASL Signer for PHP programming language.

## Installation

```bash
composer require PyaeSoneAungRgn/aws-msk-iam-sasl-signer-php
```

## Usage

```php
use PyaeSoneAung\AwsMskIamSaslSigner\AwsMskIamSaslSigner;

$awsMskIamSaslSigner = new AwsMskIamSaslSigner(
    'us-east-1', // region
    'testAccessKeyId', // iam access key id
    'testSecretAccessKey' // iam secret access key
);
$token = $awsMskIamSaslSigner->generateToken();

[
    'token' => 'aHR0cHM6Ly91cy1lYXN0LTEuYW1hem9uYXdzLmNvbS8_QWN0aW9uPWthZmthLWNsdXN0ZXIlM0FDb25uZWN0JlgtQW16LUFsZ29yaXRobT1BV1M0LUhNQUMtU0hBMjU2JlgtQW16LUNyZWRlbnRpYWw9dGVzdEFjY2Vzc0tleUlkJTJGMjAyNDAxMTQlMkZ1cy1lYXN0LTElMkZrYWZrYS1jbHVzdGVyJTJGYXdzNF9yZXF1ZXN0JlgtQW16LURhdGU9MjAyNDAxMTRUMDkxNjUyWiZYLUFtei1FeHBpcmVzPTkwMCZYLUFtei1TaWduYXR1cmU9NTQ3Yjk3YWE1OTA5ZjBmYzFkYTNjZTU4MmNkNjY2MWU5OGZhYTAzMzk3YzExYzFjZTc4MTA4NGVjYmYzN2JkZSZYLUFtei1TaWduZWRIZWFkZXJzPWhvc3Q',
    'expiryTime' => 1705230500000
]
```

## Testing

```bash
composer test
```