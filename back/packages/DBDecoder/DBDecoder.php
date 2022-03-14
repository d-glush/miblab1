<?php

class DBDecoder
{
    private string $dbFilePath;
    private string $dbDecodedFilePath;
    private string $trueSalt = 'secret';
    private string $iVector = 'vectorvectorvect';
    private string $encodeAlgo = 'aes-128-cbc-hmac-sha256';

    public function __construct()
    {
        $this->dbFilePath = $_SERVER['DOCUMENT_ROOT'] . '/src/db/database.db';
        $this->dbDecodedFilePath = $_SERVER['DOCUMENT_ROOT'] . '/src/db/database_decoded.db';
    }

    public function decode(string $salt): bool
    {
        $encodedContent = file_get_contents($this->dbFilePath);
        $content = openssl_decrypt(
            $encodedContent,
            $this->encodeAlgo,
            $salt,
            OPENSSL_RAW_DATA,
            $this->iVector
        );
        if ($this->isJson($content)) {
            file_put_contents($this->dbDecodedFilePath, $content);
            return true;
        } else {
            return false;
        }
    }

    private function isJson(string $content): bool
    {
        json_decode($content);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function encode(): void
    {
        $content = file_get_contents($this->dbDecodedFilePath);
        if (!$content) return;
        $encodedContent = openssl_encrypt(
            $content,
            $this->encodeAlgo,
            $this->trueSalt,
            OPENSSL_RAW_DATA,
            $this->iVector
        );
        file_put_contents($this->dbFilePath, $encodedContent);
    }

    public function destroyDecoded(): void
    {
        unlink($this->dbDecodedFilePath);
    }
}