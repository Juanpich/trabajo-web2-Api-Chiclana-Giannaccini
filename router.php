<?php
require_once './libs/router.php';
require_once './app/controller/products.controller.php';
require_once './app/controller/orders.controller.php';
require_once './app/controller/reviews.controller.php';
$router = new Router();
 #                 endpoint                    verbo     controller             metodo
$router->addRoute('reviews'  ,                 'GET',    'ReviewsController',   'getReviews');
$router->addRoute('reviews/:id'  ,             'GET',    'ReviewsController',   'getReview');
$router->addRoute('reviews'  ,                 'POST',   'ReviewsController',   'createReview');
$router->addRoute('reviews/:id'  ,             'PUT',    'ReviewsController',   'updateReview');
$router->addRoute('reviews/:id'  ,             'DELETE',  'ReviewsController',  'deleteReview');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);