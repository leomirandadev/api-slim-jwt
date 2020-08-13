<?php
namespace Routers;

use Controllers\UserController;
use Middleware\Jwt as JwtMiddleware;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

//========================================================================================================
//                                              POST
//========================================================================================================

$app->get('/user/{id}', function (Request $request, Response $response, array $args) {

    $user = new UserController;

    return $response->withJson([
        "ok" => $user->getByID($args['id']),
        "message" => $user->message(),
        "output" => $user->output(),
    ]);
})->add(new JwtMiddleware);

$app->get('/users', function (Request $request, Response $response, array $args) {

    $user = new UserController;

    return $response->withJson([
        "ok" => $user->getAll(),
        "message" => $user->message(),
        "output" => $user->output(),
    ]);
})->add(new JwtMiddleware);

$app->post('/user/login', function (Request $request, Response $response) {
    $params = $request->getParams();

    $user = new UserController;

    return $response->withJson([
        "ok" => $user->login($params['email'], $params['password']),
        "message" => $user->message(),
        "output" => $user->output(),
    ]);
});

$app->post('/user', function (Request $request, Response $response) {

    $params = $request->getParams();

    $user = new UserController;

    return $response->withJson([
        "ok" => $user->new($params),
        "message" => $user->message(),
        "output" => $user->output(),
    ]);
});
