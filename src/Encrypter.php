<?php
namespace Crisjohn02\Encrypter;

class Encrypter
{

    private $encrypter, $key, $cipher;

    function __construct($key)
    {
        $cipher = config('encrypter.cipher');

        $supported = [
            'AES-256-CBC',
            'AES-128-CBC'
        ];

        if (!in_array($cipher, $supported)) {
            throw new \RuntimeException(
                'Cipher not supported. Please use AES-256-CBC or AES-128-CBC'
            );
        }
        $this->cipher = $cipher;

        if (empty($key)) {
            throw new \RuntimeException(
                'User key is empty.'
            );
        }
        $this->key = base64_decode(substr($key, 7));
        $this->encrypter = new \Illuminate\Encryption\Encrypter($this->key, $cipher);
    }

    public function encrypt($value)
    {
        return $this->encrypter->encrypt($value);
    }

    public function decrypt($value)
    {
        return $this->decrypt($value);
    }
}