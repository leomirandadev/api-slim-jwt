<?php
namespace Routers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response, array $args) {
    return $response->withJson( array(  
        "ok" => TRUE,
        "msg" => "Hello World"
    ) );
});
