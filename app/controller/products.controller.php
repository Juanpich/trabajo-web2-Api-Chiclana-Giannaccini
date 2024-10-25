<?php
require_once './app/model/products.model.php';
require_once './app/model/abstract.model.php';
require_once './app/view/view.php';
class ProductsController
{
    private $view;
    private $model;
   
    public function __construct()
    {
        $this->view = new view();
        $this->model = new ProductsModel();
    }

    public function getProducts($req, $res){
        $orderBy = false;
        $filter_name = null;
        $filter_price = null;
        $filter_description = null;
        $filter_img = null;

        if(isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
        }
            if (isset($req->query->filter_name)) {
                $filter_name = $req->query->filter_name;
            }
    
            if (isset($req->query->filter_price)) {
                $filter_price = $req->query->filter_price;
            }
    
            if (isset($req->query->filter_description)) {
                $filter_description = $req->query->filter_description;
            }
    
            if (isset($req->query->filter_img)) {
                $filter_img = $req->query->filter_img;
            }
            try {
            $products = $this->model->getProducts($orderBy, $filter_name, $filter_price, $filter_description, $filter_img);
            if(!$products){
            return $this->view->showResult("Ningun producto coincide con lo buscado", 404);
        }
        return $this->view->showResult($products, 200);
    }   catch (Exception $e) {
        return $this->view->showResult("Error al buscar los productos", 500);
    }
    }

    public function getProduct($req, $res){
        $id= $req->params->id;
        if(!$this->model->checkIDExists($id)){
            return $this->view->showResult("El producto con id=".$id." no existe", 404);
        }
        $product = $this->model->getProduct($id);
        return  $this->view->showResult($product, 200);
       
    }

    public function deleteProduct($req, $res){
        $id =$req->params->id;
        if(!$this->model->checkIDExists($id)){
            return $this->view->showResult("El producto con id=".$id." no existe", 404);
        }
        $result = $this->model->eraseProduct($id);
        if($result)
            return $this->view->showResult("El producto con id=".$id." se elimino con exito", 200);
        else
            return $this->view->showResult("El producto con id=".$id." no se pudo eliminar", 500);
    }

    public function createProduct($req, $res){
        $data = $this->getValidatedProductData($req);
        if($data === null){
            return;
        }
        $last_id = $this->model->createProduct($data);
        if(!$last_id){
            return $this->view->showResult("El producto no se pudo crear", 500);
        }
        $product = $this->model->getProduct($last_id);
        return  $this->view->showResult($product, 201);
    }

    
    public function updateProduct($req, $res){
        $id= $req->params->id;
        if(!$this->model->checkIDExists($id)){
            return $this->view->showResult("El producto con id=".$id." no existe", 404);
        }
        $productData = $this->getValidatedProductData($req);
        if($productData=== null){
            return;
        }
        $result = $this->model->updateProduct($id, $productData);
        $order = $this->model->getProduct($id);
        return $this->view->showResult($order,200);
    }

    private function getValidatedProductData($req)
    {
        // Verificar campos obligatorios
        if (empty($req->body->name) || empty($req->body->price) || empty($req->body->description) ) {
                return $this->view->showResult("Faltan completar campos", 400);
        }
        $name=$req->body->name;
        $price=$req->body->price;
        $description=$req->body->description;
        $image_product = null;
        if (isset($req->body->img_product)) {
            $image_product = htmlspecialchars($req->body->img_product);
        }
        $data= [
            'name' => htmlspecialchars($name),
            'price' => htmlspecialchars($price),
            'description' => htmlspecialchars($description),
            'image_product' => htmlspecialchars($image_product) 
        ];
        return $data;
    }

}
