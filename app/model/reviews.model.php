<?php
class ReviewsModel extends modelAbstract
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getReviews($orderBy, $filter_name = null, $filter_score = null, $filter_word = null, $filter_reply = null)
    {
        $sql = "SELECT * FROM review";
        $params = [];
       
        if ($filter_name != null) {
            $sql .= ' WHERE client_name LIKE :name';
            $params[':name'] = "%" . $filter_name . "%";
        } if ($filter_score != null) {
            $sql .=  ' WHERE score = :score' ;
            $params[':score'] = $filter_score;
        } if ($filter_word != null) {
            $sql .=  ' WHERE coment LIKE :word';
            $params[':word'] = "%" . $filter_word . "%";
        } if ($filter_reply != null) {
            $sql .=  ' WHERE reply LIKE :reply';
            $params[':reply'] = "%" . $filter_reply . "%";
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
