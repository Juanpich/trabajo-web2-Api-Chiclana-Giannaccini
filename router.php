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
$router->addRoute('reviews/:id'  ,             'DELETE', 'ReviewsController',   'deleteReview');
//ordenes
$router->addRoute('orders'  ,                  'GET',    'OrdersControlers',    'getOrders');
$router->addRoute('orders/:id'  ,              'GET',    'OrdersControlers',    'getOrder');
$router->addRoute('orders'  ,                  'POST',   'OrdersControlers',    'createOrder');
$router->addRoute('orders/:id'  ,              'PUT',    'OrdersControlers',    'updateOrder');
$router->addRoute('orders/:id'  ,              'DELETE', 'OrdersControlers',    'deleteOrder');
//products
$router->addRoute('products'  ,                 'GET',    'ProductsController',    'getProducts');
$router->addRoute('products/:id'  ,             'GET',    'ProductsController',    'getProduct');
$router->addRoute('products'  ,                 'POST',   'ProductsController',    'createProduct');
$router->addRoute('products/:id'  ,             'PUT',    'ProductsController',    'updateProduct');
$router->addRoute('products/:id'  ,             'DELETE', 'ProductsController',    'deleteProduct');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);