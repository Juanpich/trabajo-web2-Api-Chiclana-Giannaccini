<?php
require_once './app/view/view.php';
require_once './app/model/reviews.model.php';
class ReviewsController{
    private $model;
    private $view;
    public function __construct(){
        $this->model = new ReviewsModel();
        $this->view =new view();
    }
    public function getReviews($req, $res){
        $orderBy = false;
        if(isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
        }
        $reviews = $this->model->getReviews($orderBy);
        if(!$reviews){
            return $this->view->showResult("No se pudieron conseguir las reviews", 404);
        }
        return $this->view->showResult($reviews, 200);
    }
}