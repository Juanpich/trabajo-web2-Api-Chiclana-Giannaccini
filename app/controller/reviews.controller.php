
<?php
require_once './app/view/view.php';
require_once './app/model/reviews.model.php';
class ReviewsController
{
    private $model;
    private $view;
    public function __construct()
    {
        $this->model = new ReviewsModel();
        $this->view = new view();
    }
    public function getReviews($req, $res)
    {
        $orderBy = false;
        $filter_name = null;
        $filter_score = null;
        $filter_word = null;
        $filter_reply = null;


        if (isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;
        }

        if (isset($req->query->filter_name)) {
            $filter_name = $req->query->filter_name;
        }

        if (isset($req->query->filter_score)) {
            $filter_score = $req->query->filter_score;
        }

        if (isset($req->query->filter_word)) {
            $filter_word = $req->query->filter_word;
        }

        if (isset($req->query->filter_reply)) {
            $filter_reply = $req->query->filter_reply;
        }
        try {
            $reviews = $this->model->getReviews($orderBy, $filter_name, $filter_score, $filter_word, $filter_reply);
            if (empty($reviews)) {
                return $this->view->showResult("Ninguna review coincide con lo buscado", 404);
            }
            return $this->view->showResult($reviews, 200);
        } catch (Exception $e) {
            return $this->view->showResult("Error al buscar las reviews: ", 500);
        }
    }

    public function getReview($req, $res){
        $id = $req->params->id;
        $review = $this->model->getReview($id);
        if (!$review) {
            return $this->view->showResult("La review con el id = $id no existe", 404);
        }
        return $this->view->showResult($review, 200);
    }

    
}
