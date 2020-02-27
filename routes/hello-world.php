<?php
namespace Routers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response, array $args) {
    return $response->withJson([  
        "ok" => TRUE,
        "message" => "Este campo mostra a mensagem do que deu errado quando o OK for FALSE",
        "output" => array("result" => "O campo output entrega os dados solicitados quando o OK estiver TRUE"),
    ]);
});
