<?php 

$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_connect($sock, "8.8.8.8", 53);
socket_getsockname($sock, $localAddr);

$folderSettings = __DIR__.'/settings/';
$keysecret = uniqid(base64_encode(rand()));

$arqsSettings = [
  array(
    'arqName'=>'ConfigDB.php',
    'conteudo'=>'<?php  
    namespace Settings;

    class ConfigDB{
        protected function getDBName():string { return "api_php"; }
        protected function getHost():string { return "'.$localAddr.'"; }
        protected function getUser():string { return "root"; }    
        protected function getPassword():string { return "root"; }
    }
    '
  ),
  array(
    'arqName'=>'ConfigJwt.php',
    'conteudo'=>'<?php  
    namespace Settings;
    class ConfigJwt{
        protected function getSecretKey():string {
          return md5("'.$keysecret.'");
        }
    }'
  )
];

include_once('SetupTools.php');

$setupTools = new SetupTools;
$setupTools->createFolderAndArqs($folderSettings, $arqsSettings);
