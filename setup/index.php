<?php 

  // pegar o ip do docker
  $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
  socket_connect($sock, "8.8.8.8", 53);
  socket_getsockname($sock, $localAddr);

  // criar uma keysecret
  $keysecret = uniqid(base64_encode(rand()));

  // arquivos que devem ser gerados e variaveis que devem ser substituidas no conteudo
  $arqsSettings = [
    [
      'arqName'=>'ConfigDB.php',
      'vars' => [ '%LOCALHOST%' => $localAddr ]
    ],
    [
      'arqName'=>'ConfigJwt.php',
      'vars' => [ '%KEYSECRET%' => $keysecret ]
    ]
  ];

  // localização da pasta de settings
  $folderSettings = __DIR__.'/../settings/';

  // inicio do setup
  include_once('SetupTools.php');
  $setupTools = new SetupTools;
  $setupTools->createFolderAndArqs($folderSettings, $arqsSettings);
