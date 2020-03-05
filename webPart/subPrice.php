<?php

session_start();
include ('include/config.php');

$query = $pdo->prepare('SELECT * FROM SUBSCRIPTION');
$query->execute();

$resultats = $query->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Souscrire à un abonnement</title>
    <!--<?php include('css/linkCss.php');?>-->
    <link rel="stylesheet" href="css/index.css">
	  <link rel="stylesheet" href="css/pricing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
</head>


<body>

<!--<?php include('include/header.php'); ?>-->


<main>

<div class="container">

  <div class="carousel">

    <?php
    $i = 0;
    foreach ($resultats as $resultat) { ?>

    <a class="carousel-item" href="#<?=$i?>">

      <div class="col s12">
        <div class="card">
          <div class="card-image">
            <center><h5><?php $resultat["subName"] ?></h5>
            <i class="material-icons" style="font-size: 50px;">grade</i></center>
          </div>
          <div class="card-content">
            <p><?= $resultat["subDays"] ?> jours sur 7.<br>
            De <?= $resultat["subHourStart"] ?> heures à <?= $resultat["subHourEnd"] ?> heures.<br>
            Contrat de <?= $resultat["subHour"] ?> heures</p>
            <h6><?= $resultat["subPrice"] ?> €</h6>
            <button type="button" onclick="document.location.href='subUser.php?idSub='+<?=$i?>" class="waves-effect waves-light btn">S'abonner</button>

          </div>
        </div>
      </div>

    </a>

    <?php $i++; } ?>

  </div>

</div>
</main>



<?php include('include/footer.php'); ?>



</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript">

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.carousel');
    var instances = M.Carousel.init(elems);
  });

</script>
</html>
