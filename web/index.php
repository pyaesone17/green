<?php

require __DIR__.'/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Green\Http\Middleware\AuthenticatedUserMiddleware;

$app = new Green\App(realpath(__DIR__));

$router = $app->get('router');
$middleware = new AuthenticatedUserMiddleware();

try{
    $router->map('POST','/token','\Green\Http\Controllers\AuthController::getToken');
    $router->map('GET','/recipes','\Green\Http\Controllers\RecipeController::index');
    $router->map('GET','/recipes/{id}','\Green\Http\Controllers\RecipeController::show');
    
    $router->group('/recipes',function ($router) {
        $router->map('POST','/','\Green\Http\Controllers\RecipeController::store');
        $router->map('PATCH','/{id}','\Green\Http\Controllers\RecipeController::update');
        $router->map('POST','/{id}/rating','\Green\Http\Controllers\RecipeController::rating');
        $router->map('DELETE','/{id}','\Green\Http\Controllers\RecipeController::delete');
    })->middleware($middleware);

    $app->run();
} catch (\Throwable $e) {
    $app->get('error_handler')->render($e);
}
