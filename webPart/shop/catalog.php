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
    <div class="row">

      <div class="input-field col s6 offset-s3">
        <input id="search_bar" type="text" class="validate" onkeyup="findService()">
        <label class="active" for="search_bar">Trouver un service en particulier</label>
      </div>
      <div class="input-field col s6 offset-s4">
          <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Faire une demande non catalogué</a>
      </div>


    <?php

      $services = $pdo->prepare("SELECT * FROM SERVICE");
      $services->execute();
      $services = $services->fetchAll();
      foreach ($services as $service) {

    ?>

    <div class="col s4 service">
      <div class="card">
        <div class="card-image">
          <img src="../images/ménage.jpeg">
          <span class="card-title"><?=$service["serviceTitle"]?></span>
        </div>
        <div class="card-content">
          <p><?=$service["serviceDescription"]?></p>
          <h6><?=$service["servicePrice"]?>/heure</h6>
        </div>
        <div class="card-action">
          <a class="waves-effect waves-light btn modal-trigger" href="#cartModal" onclick="addService('<?=addslashes($service["serviceTitle"])?>')">Ajouter au panier</a>
        </div>
      </div>
    </div>

    <?php } ?>

    </div>
  </div>

</div>

<!-- Modal Structure for cart -->
  <div id="cartModal" class="modal">
    <form class="" action="payCart.php" method="post">
    <div class="modal-content" id="cart">
      <h4>Mon panier :</h4>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-light btn">Continuer mes réservations</a>
      <button class="btn waves-effect waves-light" type="submit" name="action">Payer</button>
    </div>
    </form>
  </div>

  <!-- Modal Structure for demand -->
    <div class="modal">
      <form class="" action="demand.php" method="post">
      <div class="modal-content" id="cart">
        <h4>Faire une demande</h4>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-light btn">Continuer mes réservations</a>
        <button class="btn waves-effect waves-light" type="submit" name="action">Payer</button>
      </div>
      </form>
    </div>

  <div class="fixed-action-btn">
    <a class="btn-floating modal-trigger btn-large" href="#cartModal">
      <i class="large material-icons">shopping_cart</i>
    </a>
  </div>

</main>


  <!--formulaire exemple-->
  <div class="row" id="exemple" style="display:none">
    <div class="input-field col s2">
      <input id="serviceTitle" name="serviceTitle" type="text" class="validate" value="1" readonly>
    </div>
    <div class="input-field col s2">
      <input name="date" id="date" type="date">
    </div>
    <div class="input-field col s1">
      <p>Début:</p>
    </div>
    <div class="input-field col s2">
      <input name="timeStart" id="timeStart" type="time">
    </div>
    <div class="input-field col s1">
      <p>Fin:</p>
    </div>
    <div class="input-field col s2">
      <input name="timeStop" id="timeStop" type="time">
    </div>
    <div class="col s1">
      <a id="supServiceButton" class="btn-floating modal-trigger btn-large">
        <i class="large material-icons">clear</i>
      </a>
    </div>
  </div>

<?php include("../include/new_footer.php"); ?>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript">


document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems,);
  });

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.timepicker');
    var instances = M.Timepicker.init(elems,);
  });

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems,);
  });


  <?php if (isset($_GET["error"]) && !empty($_GET["error"])) {
    if ($_GET["error"] == "cancel") { ?>
      M.toast({html: 'Votre achat n\'a pas abouti car vous avez annuler le paiement !'});
  <?php }
    if ($_GET["error"] == "unconfirmed") { ?>
      M.toast({html: 'Votre achat n\'a pas abouti car nous n\'avons pas était en mesure de vous facturer !'});
  <?php }
      if ($_GET["error"] == "nothingInCart") { ?>
      M.toast({html: 'Votre panier est vide !'});
  <?php } } ?>


function addService(serviceTitle) {
  var cart = document.getElementById('cart');
  var form = document.getElementById('exemple'); //formulaire vide
  numberServiceInCart = form.querySelector("#serviceTitle").getAttribute("value");
  var service = document.createElement("div");
  service.setAttribute("class", "row");
  service.setAttribute("id", "form"+numberServiceInCart);
  service.innerHTML = form.innerHTML;
  service.querySelector("#serviceTitle").setAttribute("value", serviceTitle);
  service.querySelector("#serviceTitle").setAttribute("name", service.querySelector("#serviceTitle").getAttribute("name")+numberServiceInCart);
  service.querySelector("#date").setAttribute("name", service.querySelector("#date").getAttribute("name")+numberServiceInCart);
  service.querySelector("#timeStart").setAttribute("name", service.querySelector("#timeStart").getAttribute("name")+numberServiceInCart);
  service.querySelector("#timeStop").setAttribute("name", service.querySelector("#timeStop").getAttribute("name")+numberServiceInCart);
  service.querySelector("#supServiceButton").setAttribute("onclick", "delService('form"+numberServiceInCart+"')");

  cart.appendChild(service);

  form.querySelector("#serviceTitle").setAttribute("value", parseInt(numberServiceInCart)+1);

}

function delService(idService) {
  var cart = document.getElementById('cart');
  var serviceToDel = document.getElementById(idService);
  cart.removeChild(serviceToDel);
}


function findService() {
  search_bar = document.getElementById("search_bar").value;
  services = document.getElementsByClassName('service');

  for (var i = 0; i < services.length; i++) {
    var serviceNormalized = services[i].querySelector(".card-title").innerHTML.toLowerCase();
    if (serviceNormalized.indexOf(search_bar.toLowerCase()) == -1) {
      services[i].style.display = "none";
    }
    else {
      services[i].style.display = "inline-block";
    }
  };

}

</script>
</html>