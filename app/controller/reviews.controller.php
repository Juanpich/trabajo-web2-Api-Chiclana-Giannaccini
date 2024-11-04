
<?php
require_once './app/view/view.php';
require_once './app/model/reviews.model.php';
require_once './app/model/products.model.php';
class ReviewsController{

    private $model;
    private $view;
    public function __construct()
    {
        $this->model = new ReviewsModel();
        $this->view = new view();
    }
    public function getReviews($req, $res)
    {
        $order = 'asc';
        $orderBy = false;
        $filter_name = null;
        $filter_score = null;
        $filter_coment = null;
        $filter_reply = null;
        $orderValues = ['name', 'score','id_product'];

        if (isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;
            if(!in_array($orderBy, $orderValues)){
                return $this->view->showResult("No se puede ordenar por el campo ingresado", 400);
            }
        }

        if (isset($req->query->filter_name)) {
            $filter_name = $req->query->filter_name;
        }

        if (isset($req->query->filter_score)) {
            $filter_score = $req->query->filter_score;
        }

        if (isset($req->query->filter_coment)) {
            $filter_coment = $req->query->filter_coment;
        }

        if (isset($req->query->filter_reply)) {
            $filter_reply = $req->query->filter_reply;
        }
        if(isset($req->query->order)){
            $order = $req->query->order;
            if($order !== 'asc' && $order !== 'desc'){
                return $this->view->showResult("No se puede ordenar de esa forma, ingrese asc o desc", 400);
            }
        }
        try {
            $reviews = $this->model->getReviews($orderBy, $order, $filter_name, $filter_score, $filter_coment, $filter_reply);
            if (empty($reviews)) {
                return $this->view->showResult("Ninguna review coincide con lo buscado", 404);
            }
            return $this->view->showResult($reviews, 200);
        } catch (Exception $e) {
            return $this->view->showResult("Error al buscar las reviews", 500);
        }
    }

    private function checkFormData($req){
        if(empty($req->body->id_product)||empty($req->body->client_name)||empty($req->body->score)|| empty($req->body->coment)){
             $this->view->showResult("Faltan completar campos", 400);         
             return null; 
        }
        $id_product = $req->body->id_product;
        $modelProducts = new ProductsModel();
        if(!$modelProducts->checkIDExists($id_product)){
             $this->view->showResult("El id=".$id_product." del producto no existe", 404);
             return null; 
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
        if($data ===null){
            return; 
        }
        $reply = null;
        if(isset($req->body->reply)){
            $reply = $req->body->reply;
        }
        $result = $this->model->updateReview($id, $data, $reply);
        if(!$result){
            return $this->view->showResult("Ocurrio un error al actualizar la review con id= $id", 500);
        }
        $review = $this->model->getReview($id);
        if(!$review){
            return $this->view->showResult("Ocurrio un error al traer la review actualizada con id= $id", 404);
        }
        return $this->view->showResult($review, 200);
    }
    public function updateReplyReview($req, $res){
        $id = $req->params->id;
        if(!$this->model->checkIDExists($id)){
            return $this->view->showResult("El id=".$id." de la review no existe", 404);
        }
        if(!isset($req->body->reply) || empty($req->body->reply)){
            return $this->view->showResult("Complete la reply para continuar", 400);
        }
        $reply = $req->body->reply;
        $result = $this->model->updateReplyReview($id, $reply);
        if(!$result){
            return $this->view->showResult("Ocurrio un error al actualizar la reply de la review con id= $id", 500);
        }
        $review = $this->model->getReview($id);
        if(!$review){
            return $this->view->showResult("Ocurrio un error al traer la review actualizada con id= $id", 404);
        }
        return $this->view->showResult($review, 200);
    }


    public function getReview($req, $res){
        $id = $req->params->id;
        $review = $this->model->getReview($id);
        if (!$review) {
            return $this->view->showResult("La review con el id = $id no existe", 404);
        }
        return $this->view->showResult($review, 200);
    }

     public function createReview($req, $res){
        $reply = null;
        $data = $this->checkFormData($req);
        if($data ===null){
            return; 
        }
        $id= $this->model->createReview($data, $reply);
        if (!$id) {
        return $this->view->showResult("Error al insertar tarea", 500);
    }
        $review = $this->model->getReview($id);
        return $this->view->showResult($review, 200);
    }
    public function deleteReview($req, $res){
        $id =$req->params->id;
        if(!$this->model->checkIDExists($id)){
            return $this->view->showResult("La review con id=".$id." no existe", 404);
        }
        $result = $this->model->eraseReview($id);
        if($result)
            return $this->view->showResult("La review con id=".$id." se elimino con exito", 200);
        else
            return $this->view->showResult("La review con id=".$id." no se pudo eliminar", 500);
    }
   
    }
    


