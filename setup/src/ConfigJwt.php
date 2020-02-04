<?php  
    namespace Settings;
    class ConfigJwt{
        protected function getSecretKey():string {
          return md5("%KEYSECRET%");
        }
    }