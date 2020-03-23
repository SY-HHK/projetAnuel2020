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

<?php include('include/new_header.php'); ?>

<main style="margin-bottom: 200px;">

<div class="container"><center>
  <br>
  <p>
    Nous vous invitons à vous abonner, pour profiter au maximum des services de BringMe ! <br>
    En effet cela vous permet de ne pas devoir payer à chaque réservation ou demande, si celles-ci sont comprises dans votre formule alors c'est gratuit !<br>
    De plus vous pourrez profiter de nos services en dehors des horaires classiques, jusqu'à 7 jours sur 7 et 24h sur 24 !
  </p>

  <h3>Liste des formules disponible :</h3>

  <div class="carousel">

    <?php
    foreach ($resultats as $resultat) { ?>

    <a class="carousel-item" href="#<?=$resultat["idSub"]?>">

      <div class="col s12">
        <div class="card">
          <div class="card-image">
            <center><h6>Formule <?= $resultat["subName"] ?></h6>
            <i class="material-icons" style="font-size: 50px;">grade</i></center>
          </div>
          <div class="card-content">
            <p><?= $resultat["subDays"] ?> jours sur 7.<br>
            De <?= $resultat["subHourStart"] ?> heures à <?= $resultat["subHourEnd"] ?> heures.<br>
            Contrat de <?= $resultat["subHour"] ?> heures</p><br>
            <center>
              <button type="button" onclick="document.location.href='subUser.php?idSub='+<?=$resultat["idSub"]?>" class="waves-effect waves-light btn">
                <?= $resultat["subPrice"] ?> €
              </button>
            </center>

          </div>
        </div>
      </div>

    </a>

  <?php  } ?>

  </div>

</center></div>
</main>

<?php include("include/new_footer.php"); ?>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript">

<?php if (isset($_GET["error"]) && !empty($_GET["error"])) {
  if ($_GET["error"] == "cancel") { ?>
    M.toast({html: 'Votre achat n\'a pas abouti car vous avez annuler le paiement !'});
<?php }
  if ($_GET["error"] == "unconfirmed") { ?>
    M.toast({html: 'Votre achat n\'a pas abouti car nous n\'avons pas était en mesure de vous facturer !'});
<?php }
  }
?>

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.carousel');
    var instances = M.Carousel.init(elems);
  });

</script>
</html>
