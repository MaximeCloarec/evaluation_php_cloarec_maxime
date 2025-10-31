<?php

//Import de l'autoloader
include __DIR__ . "/../vendor/autoload.php";

//Chargement des variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

session_start();

/**Class import */

use App\Controller\SecurityController;
use App\Controller\BookController;


use Mithridatem\Routing\Route;
use Mithridatem\Routing\Router;
use Mithridatem\Routing\Exception\RouterException;

$router = new Router();

/**Gestion des routes */
$router->map(Route::controller('GET', '/register', SecurityController::class, 'register'));
$router->map(Route::controller('POST', '/register', SecurityController::class, 'register'));
$router->map(Route::controller('GET', '/login', SecurityController::class, 'login'));
$router->map(Route::controller('POST', '/login', SecurityController::class, 'login'));
$router->map(Route::controller('GET', '/logout', SecurityController::class, 'logout'));
$router->map(Route::controller('GET', '/book', BookController::class, 'addBookToUsers'));
$router->map(Route::controller('POST', '/book', BookController::class, 'addBookToUsers'));
$router->map(Route::controller('GET', '/books', BookController::class, 'showAllBooksUsers'));



try {
    $router->dispatch();
} catch (RouterException $e) {
    echo $e;
}
