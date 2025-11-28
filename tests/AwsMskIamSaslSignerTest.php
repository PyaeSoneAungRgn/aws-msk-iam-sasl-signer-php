<?php

use PyaeSoneAung\AwsMskIamSaslSigner\AwsMskIamSaslSigner;

it('can generateToken', function () {
    $awsMskIamSaslSigner = new AwsMskIamSaslSigner(
        'ap-southeast-1',
        'testAccessKeyId',
        'testSecretAccessKey',
    );
    $token = $awsMskIamSaslSigner->generateToken();

    expect($token)->toBeArray();
    expect($token['token'])->toBeString();
    expect($token['expiryTime'])->toBeInt();
});

it('includes session token when provided', function () {
    $sessionToken = 'FAKE_SESSION_TOKEN_ABC123';

    $signer = new AwsMskIamSaslSigner(
        'ap-southeast-1',
        'testAccessKeyId',
        'testSecretAccessKey',
        $sessionToken,
    );

    $token = $signer->generateToken();

    // Decode the returned token back into a URL to inspect the query string
    $decodedUrl = base64_decode(strtr($token['token'], '-_', '+/'));
    $parts = parse_url($decodedUrl);
    parse_str($parts['query'] ?? '', $query);

    expect($query)->toHaveKey('X-Amz-Security-Token');
    expect($query['X-Amz-Security-Token'])->toBe($sessionToken);
});
