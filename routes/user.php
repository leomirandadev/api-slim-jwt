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

$app->post('/user', function (Request $request, Response $response) {
  $args = $request->getParams();
  
  $userController = new UserController;
  
  if ( $userController->create($args) ) {
    return $response->withJson(array( "ok" => TRUE, "idInserido" => $userController->output ));
  }
  return $response->withJson(array( "ok" => FALSE, "msg" => $userController->msg ));
});
