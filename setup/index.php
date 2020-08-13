<?php

include_once 'SetupTools.php';

// arquivos que devem ser gerados e variaveis que devem ser substituidas no conteudo
$arqsSettings = [
    [
        'arqName' => 'ConfigJwt.php', 'vars' => [],
    ],
    [
        'arqName' => 'ConnectionDB.php',
        'vars' => ['%DBNAME%' => "api_php"],
    ],
];
$setupTools = new SetupTools;
$setupTools->createFolderAndArqs($arqsSettings);

$arqPhinxYml = [['arqName' => 'phinx.yml', 'vars' => []]];
$setupTools->pathArqs = __DIR__ . '/../';
$setupTools->createFolderAndArqs($arqPhinxYml);

// ssh para a jwt
$settingsPath = (string) __DIR__ . '/../settings/';
if (!file_exists($settingsPath . "private.pem")) {
    exec("openssl genrsa -out " . $settingsPath . "private.pem 2048");
    exec("openssl rsa -in " . $settingsPath . "private.pem -outform PEM -pubout -out " . $settingsPath . "public.pem");
}
