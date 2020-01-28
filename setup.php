<?php 
  
  $folderSettings = __DIR__.'/settings/';
  $keysecret = uniqid(base64_encode(rand()));

  $arqsSettings = [
    array(
      'arqName'=>'ConfigDb.php',
      'conteudo'=>'<?php  
      namespace Settings;

      class ConfigDB{
          protected function getDBName():string { return "api_php"; }
          protected function getHost():string { return "192.168.0.10"; }
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

?>