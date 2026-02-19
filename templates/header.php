<?php

  require_once("globals.php");
  require_once("db.php");
  require_once("models/Message.php");
  require_once("dao/UserDAO.php");

  $message = new Message($BASE_URL);

  $flashMessage = $message->getMessage();


  $userDao = new UserDAO($conn, $BASE_URL);

  $userData = $userDao->verifyToken(false); // verifica token e retorna os dados do usuário logado
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MovieStar</title>
  <link rel="short icon" href="<?= $BASE_URL ?>img/moviestar.ico" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" /><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <!-- CSS do projeto -->
  <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">
</head>
<body>
  <header>
  <!-- MENSAGENS DO SISTEMA -->
<?php if(!empty($flashMessage["msg"])): ?>
    <div class="msg-container container-fluid text-center p-3">
      <p class="msg <?= $flashMessage["type"] ?> m-0">
        <?= $flashMessage["msg"] ?>
      </p>
    </div>
    <?php 
      // LIMPE AQUI, depois de exibir
      $message->clearMessage(); 
    ?>
  <?php endif; ?>

  <nav id="main-navbar">
    <a href="index.php" class="navbar-brand">
      <img src="img/logo.svg" alt="MovieStar" id="logo">
      <span id="moviestar-title">MovieStar</span>
    </a>
    <!-- BOTÃO SEARCH -->
<form action="<?= $BASE_URL ?>search.php" method="GET" id="search-form">
      <input type="text" name="q" id="search" placeholder="Buscar Filmes" aria-label="Search">
      <button type="submit"><i class="bi bi-search"></i></button>
    </form> <!--vericação de usuario -->
    <?php if($userData): ?> <!--usando variavel if para verificar a existência de cadastro de usuário--> 
    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="<?= $BASE_URL ?>newmovie.php" class="nav-link"><i class="bi bi-plus-square"></i>Incluir Filme</a>
      </li>
      <li class="nav-item">
        <a href="<?= $BASE_URL ?>dashboard.php" class="nav-link">Meus Filmes</a>
      </li>
      <li class="nav-item">
        <a href="<?= $BASE_URL ?>editprofile.php" class="nav-link bold"><?= $userData->name ?></a>
      </li>
      <li class="nav-item">
        <a href="<?= $BASE_URL ?>logout.php" class="nav-link">Sair</a>
      </li>
         <?php else: ?>
      <li class="nav-item">
        <a href="<?= $BASE_URL ?>auth.php" class="nav-link">Entrar / Cadastrar</a>
      </li>
      <?php endif; ?>
    </ul>
  </nav>
  
</header>
