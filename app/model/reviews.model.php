<?php
class ReviewsModel extends modelAbstract{
    public function __construct(){
        parent::__construct();    
    }
    public function getReviews($orderBy){
        $sql = "SELECT * FROM review";
        if($orderBy){
            switch($orderBy){
                case "name":
                    $sql .= " ORDER BY client_name";
                    break;
                case "score":
                    $sql .= " ORDER BY score";
                    break;
                case "id_product":
                    $sql = " ORDER BY id_product";
                    break;
            }
        }
        $query = $this->db->prepare($sql);
        $query->execute();
        $reviews = $query->fetchAll(PDO::FETCH_OBJ);
        return $reviews;
    }
    
}