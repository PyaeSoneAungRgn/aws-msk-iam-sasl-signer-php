[![Packagist Version](https://img.shields.io/packagist/v/pyaesoneaung/aws-msk-iam-sasl-signer-php)](https://packagist.org/packages/pyaesoneaung/aws-msk-iam-sasl-signer-php)
[![Packagist Downloads](https://img.shields.io/packagist/dt/pyaesoneaung/aws-msk-iam-sasl-signer-php)](https://packagist.org/packages/pyaesoneaung/aws-msk-iam-sasl-signer-php)

# AWS MSK IAM SASL Signer for PHP 

`aws-msk-iam-sasl-signer-php` is the AWS MSK IAM SASL Signer for PHP programming language.

For more information about Amazon MSK IAM Authentication, please check out [the Amazon blog post](https://aws.amazon.com/blogs/big-data/amazon-msk-iam-authentication-now-supports-all-programming-languages/).

## Installation

```bash
composer require pyaesoneaung/aws-msk-iam-sasl-signer-php
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

// [
//     'token' => 'aHR0cHM6Ly9rYWZrYS5hcC1zb3V0aGVhc3QtMS5hbWF6b25hd3MuY29tLz9BY3Rpb249a2Fma2EtY2x1c3RlciUzQUNvbm5lY3QmVXNlci1BZ2VudD1hd3MtbXNrLWlhbS1zYXNsLXNpZ25lci1waHAlMkYxLjAuMCZYLUFtei1BbGdvcml0aG09QVdTNC1ITUFDLVNIQTI1NiZYLUFtei1DcmVkZW50aWFsPXRlc3RBY2Nlc3NLZXlJZCUyRjIwMjQwMTE0JTJGYXAtc291dGhlYXN0LTElMkZrYWZrYS1jbHVzdGVyJTJGYXdzNF9yZXF1ZXN0JlgtQW16LURhdGU9MjAyNDAxMTRUMTIyNTQ5WiZYLUFtei1FeHBpcmVzPTkwMCZYLUFtei1TaWduYXR1cmU9NWUxYzY4YzI5NDRkN2I2NjY0ZDkyMTJkMGJlMDQ1NTYyYzc5Y2U0NTZhNGJjZjg2YTQ3NTk3NDcxMjI3NTY3YyZYLUFtei1TaWduZWRIZWFkZXJzPWhvc3Q',
//     'expiryTime' => 1705236049000
// ]
```

## Kafka Usage (php-simple-kafka-client)

Kafka usage for [https://github.com/php-kafka/php-simple-kafka-client](https://github.com/php-kafka/php-simple-kafka-client)

```php
use PyaeSoneAung\AwsMskIamSaslSigner\AwsMskIamSaslSigner;
use SimpleKafkaClient\Configuration;
use SimpleKafkaClient\Producer;

$conf = new Configuration();
$conf->set('metadata.broker.list', 'kafka:9092');
$conf->set('security.protocol', 'SASL_SSL');
$conf->set('sasl.mechanisms', 'OAUTHBEARER');

$producer = new Producer($conf);

$awsMskIamSaslSigner = new AwsMskIamSaslSigner(
    'us-east-1',
    'testAccessKeyId',
    'testSecretAccessKey'
);
$token = $awsMskIamSaslSigner->generateToken();
$producer->setOAuthBearerToken($token['token'], $token['expiryTime'], 'principalClaimName=azp');

$topic = $producer->getTopicHandle('topic-name');

$topic->producev(
    RD_KAFKA_PARTITION_UA,
    RD_KAFKA_MSG_F_BLOCK,
    'value',
    'key',
    ['header-key' => 'header-value']
);

$producer->poll(0);

$result = $producer->flush(20000);
```

## Testing

```bash
composer test
```
