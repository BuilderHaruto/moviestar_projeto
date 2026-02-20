<?php
  require_once("models/User.php");
  require_once("dao/UserDAO.php");
  require_once("db.php");
  require_once("globals.php");

  $userDao = new UserDAO($conn, $BASE_URL);

  $reviewUser = $userDao->findById($review->users_id);

  if(!$reviewUser) {
    return;
  }

  if(empty($reviewUser->image)) {
    $reviewUser->image = "user.png";
  }
?>
<div class="col-md-12 review">
  <div class="row">
    <div class="col-md-1">
      <div class="profile-image-container review-image"
        style="background-image: url('<?= $BASE_URL ?>img/users/<?= $reviewUser->image ?>')">
      </div>
    </div>

    <div class="col-md-9 author-details-container">
      <h4 class="author-name">
        <a href="<?= $BASE_URL ?>profile.php?id=<?= $reviewUser->id ?>">
          <?= $reviewUser->name . " " . $reviewUser->lastname ?>
        </a>
      </h4>
      <p><i class="fas fa-star"></i> <?= $review->rating ?></p>
    </div>

    <div class="col-md-12">
      <p class="comment-title">Comentário:</p>
      <p><?= $review->review ?></p>
    </div>
  </div>
</div>
