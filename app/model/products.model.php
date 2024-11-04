<?php
require_once './config.php';
require_once './app/model/abstract.model.php';
class ProductsModel extends modelAbstract{
    public function __construct(){
        parent::__construct();    
    }
    public function getProducts($orderBy, $order, $filter_id= null, $filter_name = null, $filter_price = null, $filter_description = null, $filter_img = null) {
        $sql = "SELECT * FROM product";
        $params = [];
        $conditions = []; 
       
        if ($filter_id != null) {
            $conditions[] = 'id = ?';
            $params[] = "$filter_id";
        }
        if ($filter_name != null) {
            $conditions[] = 'name LIKE ?';
            $params[] = "%" . $filter_name . "%";
        }
        if ($filter_price != null) {
            $conditions[] = 'price = ?';
            $params[] = $filter_price;
        }
        if ($filter_description != null) {
            $conditions[] = 'description LIKE ?';
            $params[] = "%" . $filter_description . "%";
        }
        if ($filter_img != null) {
            if ($filter_img === null || $filter_img === " " || $filter_img === "null") {
                $conditions[] = 'image_product IS NULL';
            } else {
            $conditions[] = 'image_product LIKE ?';
            $params[] = "%".$filter_img . "%";
        }

    }

        if (count($conditions) > 0) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }
        if($orderBy){
            switch($orderBy){
                case "name":
                    $sql .= " ORDER BY name";
                    break;
                case "price":
                    $sql .= " ORDER BY price";
                    break;
                case "id":
                    $sql .= " ORDER BY id";
                    break;
            }
        }else{
            $sql .= " ORDER BY id";
        }
        if($order === 'desc'){
            $sql .= " DESC";
        }else if($order === 'asc'){
            $sql .= " ASC";
        }
        $query = $this->db->prepare($sql);
        $query->execute($params);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function getProduct($id) {
        $query = $this->db->prepare("SELECT * FROM product WHERE id = ?");
        $result = $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function checkIDExists($id_product){
        $query = $this->db->prepare("SELECT * FROM product WHERE id = ?");
        $result = $query->execute([$id_product]);
        return $query->fetchColumn() > 0;
    }

    //CRUD
    public function createProduct($data){
        $query = $this->db->prepare('INSERT INTO product(name,price,description,image_product) VALUES (?, ?, ?, ?)');
        $query->execute([$data['name'],$data['price'], $data['description'], $data['image_product']]);
        $id = $this->db->lastInsertId();
        return $id;
    }

    public function eraseProduct($id){
        $query = $this->db->prepare('DELETE FROM product WHERE id = ?');
        $result = $query->execute([$id]);
        return $result;
    }

    public function updateProduct($id, $productData) {
        $query = $this->db->prepare('UPDATE product SET name = ?, price = ?, description = ?, image_product = ? WHERE id = ?');
        $query->execute([$productData['name'], $productData['price'], $productData['description'], $productData['image_product'],$id]);
                return true; 
     } 
}

