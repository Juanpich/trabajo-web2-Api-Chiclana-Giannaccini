<?php
require_once './app/view/view.php';
require_once './app/model/reviews.model.php';
require_once './app/model/products.model.php';
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
    private function checkFormData($req){
        var_dump($req->body);
        if(empty($req->body->id_product)||empty($req->body->client_name)||empty($req->body->score)|| empty($req->body->coment)){
            $this->view->showResult("Faltan completar campos", 400);
            return;
            die();
            
        }
        $id_product = $req->body->id_product;
        $modelProducts = new ProductsModel();
        if(!$modelProducts->checkIDExists($id_product)){
            return $this->view->showResult("El id=".$id_product." del producto no existe", 404);
        }
        $client_name = $req->body->client_name;
        $score = $req->body->score;
        if($score < 1){
            $score = 1;
        }
        if($score > 5){
            $score = 5;
        }
        $coment = $req->body->coment;
        $data =array(
            "id_product" => $id_product,
            "client_name"=>$client_name,
            "score"=>$score,
            "coment"=>$coment
        );
        return $data;
    }
    public function updateReview($req, $res){
        $id = $req->params->id;
        if(!$this->model->checkIDExists($id)){
            return $this->view->showResult("El id=".$id." de la review no existe", 404);
        }
        $data = $this->checkFormData($req);
        $reply = null;
        if(isset($req->body->reply)){
            $reply = $req->body->reply;
        }
        $this->model->updateReview($id, $data, $reply);
        //$review = $this->getReview($id); DESCOMENTAR DONDE MAJO TERMINE EL getReview
        return $this->view->showResult("El id=".$id. " se modifico con exito", 200);
    }
}