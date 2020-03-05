<?php
session_start();
include("include/config.php");

$getUserInfos = $pdo->prepare("SELECT * FROM USER WHERE userGuid = ?");
$getUserInfos->execute([$_SESSION["user"]["userGuid"]]);
$nbUser = $getUserInfos->rowCount();
if ($nbUser == 0) {
  header("location: php/deconnexion.php");
  exit;
}
else {
  $getUserInfos = $getUserInfos->fetch();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
</head>


<body>

<!--<?php include('include/header.php'); ?>-->

<header>
  <nav class="blue-grey darken-3">
    <div class="nav-wrapper">
      <a href="index.php" class="brand-logo"><img src="images/logo.png" style="width: 90px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="subPrice.php">Abonnement</a></li>
        <?php
        if (isset($_SESSION["user"]) && !empty($_SESSION["user"]))
        { ?>
          <li><a href="profilUser.php">Profil</a></li>
      <?php  } else { ?>
          <li><a href="connexion.php">Se connecter</a></li>
      <?php  } ?>
      </ul>
    </div>
  </nav>
</header>

<main style="margin-bottom: 200px;">






</main>

<footer class="page-footer blue-grey darken-3">
  <div class="footer-copyright">
    <div class="container">
      <p style="color: white"> © <?php echo date('Y'); ?> site officiel de <a class="lien" href="index.php"> BringMe </a></p>
    </div>
  <div>
</footer>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
