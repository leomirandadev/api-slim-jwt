<?php
namespace Routers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Controllers\UserController;

$app->get('/users', function (Request $request, Response $response, array $args) {
  
  $userController = new UserController;
  
  if ( $userController->getAll() ) {
    return $response->withJson(array( "ok" => TRUE, "output" => $userController->output ));
  }
  return $response->withJson(array( "ok" => FALSE, "msg" => $userController->msg ));
});
