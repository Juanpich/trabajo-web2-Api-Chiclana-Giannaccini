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
                    $sql .= " ORDER BY id_product";
                    break;
            }
        }
        $query = $this->db->prepare($sql);
        $query->execute();
        $reviews = $query->fetchAll(PDO::FETCH_OBJ);
        return $reviews;
    }
    public function checkIDExists($id){
        $query = $this->db->prepare("SELECT * FROM review WHERE id = ?");
        $query->execute([$id]);
        return $query->fetchColumn() > 0;
    }
    public function updateReview($id, $data, $reply){
        $query = $this->db->prepare("UPDATE review SET id_product = ?, client_name = ?, score = ?, coment = ?, reply = ? WHERE review . id = ?");
        $query->execute([$data['id_product'], $data['client_name'], $data['score'], $data['coment'], $reply, intval($id)]);
        return;
    }
    
}