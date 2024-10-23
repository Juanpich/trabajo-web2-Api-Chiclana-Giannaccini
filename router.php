<?php
require_once './libs/router.php';
require_once './app/controller/products.controller.php';
require_once './app/controller/orders.controller.php';
$router = new Router();
 #                 endpoint                    verbo     controller             metodo
$router->addRoute('reviews'  ,                 'GET',    'ReviewController',   'getReviews');
$router->addRoute('reviews/:id'  ,             'GET',    'ReviewController',   'getReview');
$router->addRoute('reviews'  ,                 'POST',   'ReviewController',   'createReview');
$router->addRoute('reviews/:id'  ,             'PUT',    'ReviewController',   'updateReview');
$router->addRoute('reviews/:id'  ,             'DELETE',  'ReviewController',  'deleteReview');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);