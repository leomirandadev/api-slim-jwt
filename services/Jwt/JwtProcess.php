<?php
namespace Jwt;

use Settings\ConfigJwt;
use \Firebase\JWT\JWT;

class JwtProcess extends ConfigJwt
{

    private $key;
    public $payload;
    const oneDayTime = 60 * 60 * 24;

    /**
     * encode
     *
     * @param  array $payload
     *
     * @return string
     */
    public static function encode(array $payload): string
    {

        if (self::$expire) {
            $payload['exp'] = time() + (self::$daysToExp * self::oneDayTime);
        }

        $jwt = JWT::encode($payload, self::getPrivateKey(), 'RS256');
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
            $decoded = JWT::decode($jwt, self::getPublicKey(), array('RS256'));
            $this->payload = json_decode(json_encode($decoded), true);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

}
