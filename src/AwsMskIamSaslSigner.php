<?php

namespace PyaeSoneAung\AwsMskIamSaslSigner;

use Aws\Credentials\Credentials;
use Aws\Signature\SignatureV4;
use GuzzleHttp\Psr7;

class AwsMskIamSaslSigner
{
    public const VERSION = '1.0.0';

    public function __construct(
        private readonly string $region,
        private readonly string $accessKeyId,
        private readonly string $secretAccessKey,
        private readonly ?string $sessionToken = null
    ) {}

    public function generateToken(?int $expiryInSeconds = 900): array
    {
        $signatureV4 = new SignatureV4('kafka-cluster', $this->region);

        $credentials = new Credentials($this->accessKeyId, $this->secretAccessKey, $this->sessionToken);

        $host = "kafka.{$this->region}.amazonaws.com";

        $request = new Psr7\Request(
            'GET',
            "https://{$host}?Action=kafka-cluster:Connect",
            ['host' => $host],
        );

        $presignedRequest = $signatureV4->presign($request, $credentials, time() + $expiryInSeconds);

        parse_str($presignedRequest->getUri()->getQuery(), $queries);
        $queries['User-Agent'] = 'aws-msk-iam-sasl-signer-php/'.static::VERSION;
        ksort($queries);
        $queryString = http_build_query($queries);

        $base64EncodedString = base64_encode("https://{$host}/?{$queryString}");
        $base64UrlEncodedString = rtrim(strtr($base64EncodedString, '+/', '-_'), '=');

        return [
            'token' => $base64UrlEncodedString,
            'expiryTime' => (strtotime($queries['X-Amz-Date']) + $expiryInSeconds) * 1000,
        ];
    }
}
