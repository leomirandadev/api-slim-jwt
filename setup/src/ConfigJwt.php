<?php
namespace Settings;

class ConfigJwt
{

    protected function getPrivateKey()
    {
        return file_get_contents(__DIR__ . '/private.pem');
    }

    protected function getPublicKey()
    {
        return file_get_contents(__DIR__ . '/public.pem');
    }
}
