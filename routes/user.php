<?php
namespace Routers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Jwt\JwtProcess, Middleware\Jwt as JwtMiddleware;
use Controllers\UserController;

$app->get('/users', function (Request $request, Response $response, array $args) {
  $userController = new UserController;
  
  if ( $userController->getAll() ) {
    return $response->withJson(array( "ok" => TRUE, "output" => $userController->output ));
  }
  return $response->withJson(array( "ok" => FALSE, "message" => $userController->message ));

})->add(new JwtMiddleware);

$app->get('/user/{id}', function (Request $request, Response $response, array $args) {

  $userController = new UserController;
  
  if ( $userController->getById($args['id']) ) {
    return $response->withJson(array( "ok" => TRUE, "output" => $userController->output ));
  }
  return $response->withJson(array( "ok" => FALSE, "message" => $userController->message ));

})->add(new JwtMiddleware);

$app->post('/user', function (Request $request, Response $response) {

  $args = $request->getParams();
  $userController = new UserController;
  
  if ( $userController->create($args) ) {
    return $response->withJson(array( "ok" => TRUE, "idInserido" => $userController->output ));
  }
  return $response->withJson(array( "ok" => FALSE, "message" => $userController->message ));

});

$app->post('/user/login', function (Request $request, Response $response) {

  $userController = new UserController;

  if ($userController->login($request->getParams())) {
      $jwt = new JwtProcess;
      $token = $jwt->encode($userController->output);
      return $response->withJson( array("ok" => TRUE, "output" => $userController->output, "token" => $token) );
  }
  return $response->withJson( array("ok" => FALSE, "output" => $userController->output) );

});

$app->patch('/user/{id}/password', function (Request $request, Response $response, array $args) {
  $data = $request->getParams();
  $userController = new UserController;
  
  if ( $userController->changePassword($args['id'], $data) ) {
    return $response->withJson(array( "ok" => TRUE, "message" => $userController->message ));
  }
  return $response->withJson(array( "ok" => FALSE, "message" => $userController->message ));
})->add(new JwtMiddleware);

$app->put('/user/{id}', function (Request $request, Response $response, array $args) {
  $data = $request->getParams();
  $userController = new UserController;
  
  if ( $userController->update($args['id'], $data) ) {
    return $response->withJson(array( "ok" => TRUE, "message" => $userController->message ));
  }
  return $response->withJson(array( "ok" => FALSE, "message" => $userController->message ));
});