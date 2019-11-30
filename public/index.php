<?php

require '../autoload.php';

use \MyRoute\Route;
use MyRoute\Helper;
use App\controllers\MainController;

Route::addRoute("GET","/", [MainController::class, 'index']);
Route::addRoute("GET","/home", [MainController::class, 'home']);
Route::addRoute("GET","/about/{user}[/{age:\d+}]", [MainController::class, 'about']);
Route::addRoute("GET","/posts[/{id:\d+}]", [MainController::class, 'news']);

$httpMethod = $_SERVER['REQUEST_METHOD'];
$query = Helper::prepareQuery($_SERVER['REQUEST_URI']);

$routeInfo = Route::checkQuery($httpMethod, $query);

switch ($routeInfo['status'])
{
    case Route::NOT_FOUND:
        echo 404;
        break;
    case Route::METHOD_NOT_ALLOWED:
        echo 'Неверный метод, доступ запрещен.';
        break;
    case Route::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo['vars'];
        Helper::handlerCall($handler, $vars);
        break;
}
