<?php

$trueSalt = 'secret';
$iVector = 'vectorvectorvect';
$encodeAlgo = 'aes-128-cbc-hmac-sha256';
$dbFilePath = $_SERVER['DOCUMENT_ROOT'] . '/src/db/database.db';

$array = [
    [
        'login' => 'admin',
        'password' => '',
        'role' => 'admin',
        'is_banned' => false,
        'is_password_limit' => false,
    ],
];
$jsoned = json_encode($array);

$encodedContent = openssl_encrypt(
    $jsoned,
    $encodeAlgo,
    $trueSalt,
    OPENSSL_RAW_DATA,
    $iVector
);
file_put_contents($dbFilePath, $encodedContent);

echo 'OK';
