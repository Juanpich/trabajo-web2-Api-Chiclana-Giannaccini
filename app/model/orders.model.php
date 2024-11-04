<?php
require_once './app/model/abstract.model.php';
require_once './config.php';
class OrdersModel extends modelAbstract{
    public function __construct(){
        parent::__construct();   
    }
    public function getOrders($orderBy, $order, $filter_total,$filter_cant_products,$filter_date,$filter_total_greater,$filter_total_minor){
        $sql = "SELECT * FROM orders";
        $params = [];
        $conditions = []; 
        if ($filter_total != null) {
            $conditions[] = 'total = ?';
            $params[] = $filter_total;
        }
        if ($filter_cant_products != null) {
            $conditions[] = 'cant_products = ?';
            $params[] = $filter_cant_products;
        }
        if ($filter_date != null) {
            $conditions[] = 'date = ?';
            $params[] = $filter_date;
        }
        if ($filter_total_greater != null) {
            $conditions[] = 'total > ?';
            $params[] = $filter_total_greater;
        }
        if ($filter_total_minor != null) {
            $conditions[] = 'total < ?';
            $params[] = $filter_total_minor;
        }
        if (count($conditions) > 0) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }
        if($orderBy){
            switch($orderBy){
                case "date":
                    $sql .= " ORDER BY date";
                    break;
                case "total":
                    $sql .= " ORDER BY total";
                    break;
                case "cant_products":
                    $sql .= " ORDER BY cant_products";
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
        $orders = $query->fetchAll(PDO::FETCH_OBJ);
        return $orders;
    }
    public function getOrder($id){
        $query = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $result = $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function checkIDExists($id){
        $query = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $query->execute([$id]);
        return $query->fetchColumn() > 0;
    }
    
    public function updateOrder($id, $data){
        $query = $this->db->prepare("UPDATE orders SET id_product = ?, cant_products = ?, total = ?, date = ? WHERE  orders . id = ?");
        $result = $query->execute([$data["id_product"], $data["cant_products"],  $data["total"], $data["date"], $id]);
        return $result;
    }
    public function eraseOrder($id){
        $query = $this->db->prepare("DELETE FROM orders WHERE id = ?");
        $result = $query->execute([$id]);
        return $result;
    }
    public function createOrder($data){
        $query = $this->db->prepare("INSERT INTO orders (id_product, cant_products, total, date) VALUES (?, ?, ?, ?)");
        $query->execute([$data["id_product"], $data["cant_products"],  $data["total"], $data["date"]]);
        $id = $this->db->lastInsertId();
        return $id;
    }

    
    
}

