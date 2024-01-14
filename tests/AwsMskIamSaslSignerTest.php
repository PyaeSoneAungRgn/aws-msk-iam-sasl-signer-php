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
