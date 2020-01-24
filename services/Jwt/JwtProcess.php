<?php
    namespace Jwt;
    use \Firebase\JWT\JWT;
    
    class JwtProcess {
        
        private $key;
        public $payload;
        
        function __construct() {
            $this->key = md5("45rRVuciUR9UsPfr#ssDouXZ_flwFOLpd7BgrObDkVIbRnRt0");
        }
        
        /**
         * encode
         *
         * @param  array $payload
         *
         * @return string
         */
        public function encode(array $payload):string {
            // $dia = 60*60*24;
            // $payload['exp'] = time() + 1*$dia;
            $jwt = JWT::encode($payload, $this->key, 'HS256');
            return $jwt;
        }

        /**
         * decode
         *
         * @param  string $jwt
         *
         * @return bool
         */
        public function decode(string $jwt):bool {
            try {
                $decoded = JWT::decode($jwt, $this->key, array('HS256'));
                $this->payload = json_decode(json_encode($decoded),true);
                return true;
            } catch (\Throwable $th) {
                return false;
            }
        }


    }
?>