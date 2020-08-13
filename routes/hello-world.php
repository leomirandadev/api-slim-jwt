<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', function (Request $request, Response $response, array $args) {
    return $response->withJson([
        "ok" => true,
        "message" => "Este campo mostra a mensagem do que deu errado quando o OK for FALSE",
        "output" => array("result" => "O campo output entrega os dados solicitados quando o OK estiver TRUE"),
    ]);
});
