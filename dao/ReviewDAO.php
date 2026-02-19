<?php

// Inclui o Model Review
require_once(__DIR__ . "/../models/Review.php");

class ReviewDao {

    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Monta o objeto Review
    public function buildReview($data) {
        $reviewObject = new Review();
        
        $reviewObject->id = $data["id"];
        $reviewObject->rating = $data["rating"];
        $reviewObject->review = $data["review"];
        $reviewObject->users_id = $data["users_id"];
        $reviewObject->movies_id = $data["movies_id"];

        return $reviewObject;
    }

    // Cria review
    public function create(Review $review) {

        if($this->hasAlreadyReviewed($review->movies_id, $review->users_id)) {
            return false;
        }

        $stmt = $this->conn->prepare("
            INSERT INTO reviews (rating, review, users_id, movies_id)
            VALUES (:rating, :review, :users_id, :movies_id)
        ");

        $stmt->bindParam(":rating", $review->rating);
        $stmt->bindParam(":review", $review->review);
        $stmt->bindParam(":users_id", $review->users_id);
        $stmt->bindParam(":movies_id", $review->movies_id);

        $stmt->execute();

        return true;
    }

    // Busca todas as reviews de um filme
    public function getMoviesReview($id) {

        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id");
        $stmt->bindParam(":movies_id", $id);
        $stmt->execute();

        $reviews = [];

        foreach($stmt->fetchAll() as $data) {
            $reviews[] = $this->buildReview($data);
        }

        return $reviews;
    }

    // Verifica se o usuário já avaliou o filme
    public function hasAlreadyReviewed($movieId, $userId) {

        $stmt = $this->conn->prepare("
            SELECT id FROM reviews 
            WHERE movies_id = :movies_id AND users_id = :user_id
        ");

        $stmt->bindParam(":movies_id", $movieId);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Calcula média das avaliações
    public function getRatings($id) {

        $stmt = $this->conn->prepare("
            SELECT rating  
            FROM reviews 
            WHERE movies_id = :id
        ");

        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if($stmt->rowCount() > 0) {

            $ratings = $stmt->fetchAll();
            $total = 0;

            foreach($ratings as $item){
                $total += $item["rating"];
            }

            $media = $total / count($ratings);
            return round($media, 1);
        }

        return 0;
    }
}
