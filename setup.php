<?php 
  
  $folderSettings = __DIR__.'/settings/';
  $arqsSettings = [
    array(
      'arqName'=>'ConfigDb.php',
      'conteudo'=>'<?php  
      namespace Settings;

      class ConfigDB{
          protected function getDBName():string { return "api_php"; }
          protected function getHost():string { return "db"; }
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
            return md5("45rRVuciUR9UsPfr#ssDouXZ_flwFOLpd7BgrObDkVIbRnRt0");
          }
      }'
    )
  ];

  include_once('SetupTools.php');

  $setupTools = new SetupTools;
  $setupTools->createFolderAndArqs($folderSettings, $arqsSettings);

?>