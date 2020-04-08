<?php
include ('../include/lang.php');
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
    <title><?php echo $lang['titleSubPrice']; ?></title>
    <!--<?php include('css/linkCss.php');?>-->
	  <link rel="stylesheet" href="css/pricing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
</head>


<body>

<?php include('../include/new_header.php'); ?>

<main style="margin-bottom: 200px;">

<div class="container"><center>
  <br>
  <p>
      <?php echo $lang['subPriceText1']; ?> <br>
      <?php echo $lang['subPriceText2']; ?><br>
      <?php echo $lang['subPriceText3']; ?>
  </p>

  <h3><?php echo $lang['availableFormulas']; ?></h3>

  <div class="carousel">

    <?php
    foreach ($resultats as $resultat) { ?>

    <a class="carousel-item" href="#<?=$resultat["idSub"]?>">

      <div class="col s12">
        <div class="card">
          <div class="card-image">
            <center><h6><?php echo $lang['formula']; ?> <?= $resultat["subName"] ?></h6>
            <i class="material-icons" style="font-size: 50px;">grade</i></center>
          </div>
          <div class="card-content">
            <p><?= $resultat["subDays"] ?> <?php echo $lang['subDays']; ?> 7.<br>
            De <?= $resultat["subHourStart"] ?> <?php echo $lang['subHours2']; ?> <?= $resultat["subHourEnd"] ?> <?php echo $lang['subHours']; ?>.<br>
                <?php echo $lang['subContract']; ?> <?= $resultat["subHour"] ?> <?php echo $lang['subHours']; ?></p><br>
            <center>
              <button type="button" onclick="document.location.href='subUser.php?idSub='+<?=$resultat["idSub"]?>" class="waves-effect waves-light btn">
                <?= $resultat["subPrice"] ?> €/<?php echo $lang['year']; ?>
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

<?php include("../include/new_footer.php"); ?>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript">

<?php if (isset($_GET["error"]) && !empty($_GET["error"])) {
  if ($_GET["error"] == "cancel") { ?>
    M.toast({html: '<?php echo $lang['error=cancel']; ?>'});
<?php }
  if ($_GET["error"] == "unconfirmed") { ?>
    M.toast({html: '<?php echo $lang['error=unconfirmed']; ?>'});
<?php }
  }
?>

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.carousel');
    var instances = M.Carousel.init(elems);
  });

</script>
</html>
