<?php
class ReviewsModel extends modelAbstract
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getReviews($orderBy, $order, $filter_name = null, $filter_score = null, $filter_coment = null, $filter_reply = null)
    {
        $sql = "SELECT * FROM review";
        $params = [];
        $conditions = [];  
        
        
        if ($filter_name != null) {
            $conditions[] = 'client_name LIKE ?';
            $params[] = "%" . $filter_name . "%";  
        }
        if ($filter_score != null) {
            $conditions[] = 'score = ?';
            $params[] = $filter_score;
        }
        if ($filter_coment != null) {
            $conditions[] = 'coment LIKE ?';
            $params[] = "%" . $filter_coment . "%";
        }
        if ($filter_reply != null) {
            $conditions[] = 'reply LIKE ?';
            $params[] = "%" . $filter_reply . "%";
        }
        
        // Construcción de la cláusula WHERE
        if (count($conditions) > 0) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }
        
        if ($orderBy) {
            switch ($orderBy) {
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
    public function getReview($id) {    
        $query = $this->db->prepare('SELECT * FROM review WHERE id = ?');
        $query->execute([$id]);   
        $review = $query->fetch(PDO::FETCH_OBJ);
        return $review;
    }
    public function createReview($data,$reply){
        $query = $this->db->prepare('INSERT INTO review(id_product, client_name, score, coment) VALUES (?, ?, ?, ?)');
        $query->execute([$data['id_product'], $data['client_name'], $data['score'], $data['coment']]);
        $id = $this->db->lastInsertId();
        return $id;
    }
   
}
