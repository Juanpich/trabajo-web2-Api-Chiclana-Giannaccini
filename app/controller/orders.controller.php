<?php
require_once './app/model/orders.model.php';
require_once './app/view/view.php';
require_once './app/model/abstract.model.php';
require_once './app/model/products.model.php';
class OrdersControlers{
    private $view;
    private $model;
    private $error;
  
    public function __construct(){
        $this->view = new view();
        $this->model = new OrdersModel();
    }
    public function getOrders($req, $res){
        $orderBy = false;
        if(isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
        }
        $orders = $this->model->getOrders($orderBy);
        if(!$orders){
            return $this->view->showResult("Las ordenes no se pudieron conseguir", 404);
        }
        return $this->view->showResult($orders, 200);
    }
    public function getOrder($req, $res){
        $id= $req->params->id;
        if(!$this->model->checkIDExists($id)){
            return $this->view->showResult("La orden con id=".$id." no existe", 404);
        }
        $order = $this->model->getOrder($id);
        return  $this->view->showResult($order, 200);
       
    }
    public function deleteOrder($req, $res){
        $id =$req->params->id;
        if(!$this->model->checkIDExists($id)){
            return $this->view->showResult("La orden con id=".$id." no existe", 404);
        }
        $result = $this->model->eraseOrder($id);
        if($result)
            return $this->view->showResult("La orden con id=".$id." se elimino con exito", 200);
        else
            return $this->view->showResult("La orden con id=".$id." no se pudo eliminar", 500);
    }
    private function checkFormData($req){
        if(empty($req->body->id_product) || empty($req->body->cant_products) || empty($req->body->date)){
            return $this->view->showResult("Faltan completar campos", 400);
        }
        $id_product = $req->body->id_product;   
        $modelProducts = new ProductsModel();
        if(!$modelProducts->checkIDExists($id_product)){
            return $this->view->showResult("El id=".$id_product." del producto no existe", 404);
        }
        $cant_products = $req->body->cant_products;
        if($cant_products <=0){
            return $this->view->showResult("ingrese datos validos", 400);
        }
        $date = $req->body->date;
        $product = $modelProducts->getProduct($id_product);
        $total = $product->price * $cant_products;
        $data = array(
            "id_product"=>$id_product,
            "cant_products"=>$cant_products,
            "date"=>$date,
            "total"=>$total
        );
        return $data;
    }
    public function updateOrder($req, $res){
        $id= $req->params->id;
        if(!$this->model->checkIDExists($id)){
            return $this->view->showResult("La orden con id=".$id." no existe", 404);
        }
        $data = $this->checkFormData($req);
        $this->model->updateOrder($id, $data);
        $order = $this->model->getOrder($id);
        return $this->view->showResult($order,200);
    }
    public function createOrder($req, $res){
        $data = $this->checkFormData($req);
        $last_id = $this->model->createOrder($data);
        if(!$last_id){
            return $this->view->showResult("La orden no se pudo crear", 500);
        }
        $order = $this->model->getOrder($last_id);
        return  $this->view->showResult($order, 201);
    }
}