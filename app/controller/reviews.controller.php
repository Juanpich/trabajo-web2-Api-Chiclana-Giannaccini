<?php
require_once './app/view/view.php';
require_once './app/model/reviews.model.php';
class ReviewsController{
    private $model;
    private $view;
    public function __construct(){
        $this->model = new view();
    }
}