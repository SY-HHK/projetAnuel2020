<?php
session_start();
if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
  header("location: ../login/connexion.php?error=plz_login");
  exit;
}

include ('../include/config.php');

$query = $pdo->prepare('SELECT * FROM SUBSCRIPTION');
$query->execute();

$resultats = $query->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
</head>


<body>

<?php include('../include/new_header.php'); ?>

<main style="margin-bottom: 5%;">

<div class="container">

  <div class="list">

    <?php

      $services = $pdo->prepare("SELECT * FROM SERVICE");
      $services->execute();
      $services = $services->fetchAll();
      foreach ($services as $service) {

    ?>

  <div class="row">
    <div class="col s12 m7">
      <div class="card">
        <div class="card-image">
          <img src="../images/ménage.jpeg">
          <span class="card-title">Ménage</span>
        </div>
        <div class="card-content">
          <p>Ménage blabla</p>
        </div>
        <div class="card-action">
          <a href="#">This is a link</a>
        </div>
      </div>
    </div>
  </div>

    <?php } ?>

  </div>

</div>


</main>

<?php include("../include/new_footer.php"); ?>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript">


</script>
</html>
