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
        $firstCondition = true; //agregue para filtrar por mas de un campo

        if ($filter_name != null) {
            $sql .= $firstCondition ? ' WHERE client_name LIKE :name' : ' AND client_name LIKE :name';
            $firstCondition = false;
        } if ($filter_score != null) {
            $sql .= $firstCondition ? ' WHERE score = :score' : 'AND score = :score';
            $firstCondition = false;
        } if ($filter_word != null) {
            $sql .= $firstCondition ? ' WHERE coment LIKE :word' : 'AND coment = :coment';
            $firstCondition = false;
        } if ($filter_reply != null) {
            $sql .= $firstCondition ? ' WHERE reply LIKE :reply' : ' AND reply LIKE :reply';
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
                    $sql .= " ORDER BY id_product"; //faltaba un .
                    break;
            }
        }
        $query = $this->db->prepare($sql);

        if ($filter_name != null) {
            $filter_name = "%" . $filter_name . "%";
            $query->bindParam(':name', $filter_name, PDO::PARAM_STR);
        }
        if ($filter_score != null) {
            $query->bindParam(':score', $filter_score, PDO::PARAM_STR);
        }
        if ($filter_word != null) {
            $filter_word = "%" . $filter_word . "%"; 
            $query->bindParam(':word', $filter_word, PDO::PARAM_STR);
        }
        if ($filter_reply != null) {
            $filter_reply = "%" . $filter_reply . "%";
            $query->bindParam(':reply', $filter_reply, PDO::PARAM_STR);
        }
        $query->execute();
        $reviews = $query->fetchAll(PDO::FETCH_OBJ);
        return $reviews;
    }

    public function getReview($id) {    
        $query = $this->db->prepare('SELECT * FROM review WHERE id = ?');
        $query->execute([$id]);   
        $review = $query->fetch(PDO::FETCH_OBJ);
        return $review;
    }
    
   
}
