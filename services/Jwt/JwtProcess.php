<?php
namespace Jwt;

use Settings\ConfigJwt;
use \Firebase\JWT\JWT;

class JwtProcess extends ConfigJwt
{

    private $key;
    public $payload;

    /**
     * encode
     *
     * @param  array $payload
     *
     * @return string
     */
    public function encode(array $payload): string
    {
        // $dia = 60*60*24;
        // $payload['exp'] = time() + 1*$dia;
        $jwt = JWT::encode($payload, $this->getPrivateKey(), 'RS256');
        return $jwt;
    }

    /**
     * decode
     *
     * @param  string $jwt
     *
     * @return bool
     */
    public function decode(string $jwt): bool
    {
        try {
            $decoded = JWT::decode($jwt, $this->getPublicKey(), array('RS256'));
            $this->payload = json_decode(json_encode($decoded), true);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

}
