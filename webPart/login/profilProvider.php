<?php
session_start();
include("../include/config.php");
include('../include/lang.php');
if (!isset($_SESSION["provider"])) {
  //header("location: ../php/deconnexion.php");
  exit;
}

$getProviderInfos = $pdo->prepare("SELECT * FROM PROVIDER INNER JOIN CITY ON providerIdCity = idCity WHERE providerGuid = ?");
$getProviderInfos->execute([$_SESSION["provider"]]);
$nbProvider = $getProviderInfos->rowCount();
if ($nbProvider == 0) {
  header("location: ../php/deconnexion.php");
  echo $_SESSION["provider"];
  exit;
}
else {
  $providerInfos = $getProviderInfos->fetch();
  $idProvider = $providerInfos["idProvider"];
}

if (date("D",time()) == "Mon") $monday = date("Y-m-d",time());
else $monday = date("Y-m-d", strtotime(date("Y-m-d",time())."last monday"));
$week = array(
  "monday" => $monday,
  "tuesday" => date("Y-m-d", strtotime($monday."+1 days")),
  "wednesday" => date("Y-m-d", strtotime($monday."+2 days")),
  "thursday" => date("Y-m-d", strtotime($monday."+3 days")),
  "friday" => date("Y-m-d", strtotime($monday."+4 days")),
  "saturday" => date("Y-m-d", strtotime($monday."+5 days")),
  "sunday" => date("Y-m-d", strtotime($monday."+6 days")),
);

$color = array();
$initColorArray = $pdo->prepare("SELECT idDelivery FROM DELIVERY WHERE idProvider = ? && deliveryDateStart >= ? && deliveryDateStart <= ?");
$initColorArray->execute([$idProvider, $week["monday"], $week["sunday"]]);
$idDeliveryArray = $initColorArray->fetchAll();
$i = 0;
foreach ($idDeliveryArray as $idDelivery) {
  $color[$idDelivery["idDelivery"]] = "teal lighten-".$i;
  if ($i == 5) $i = 0;
  else $i++;
}

function getDeliveyDayOfWeek($pdo, $idProvider, $day, $i) {
  $getDeliveryInfos = $pdo->prepare("SELECT * FROM DELIVERY INNER JOIN SERVICE ON DELIVERY.idService = SERVICE.idService
    WHERE idProvider = ? && deliveryDateStart = ? &&
    ((deliveryHourStart >= ? && deliveryHourStart < ?) || (deliveryHourStart < ? && deliveryHourEnd > ?))
    ORDER BY deliveryHourStart ASC");
  $getDeliveryInfos->execute([$idProvider, $day, $i.":00:00", ($i+1).":00:00", $i.":00:00", $i.":00:00"]);
  return $getDeliveryInfos->fetchall();
}

function isFirstHour($delivery, $i) {
  if (strtotime($delivery["deliveryHourStart"]) >= strtotime($i.":00:00") && strtotime($delivery["deliveryHourStart"]) <= strtotime(($i+1).":00:00")) return 1;
  else return 0;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lang['titleProfile']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
    <style media="screen">
      tr {
        padding: 0px;
      }
      td {
        padding: 0px;
        width: 12%;
      }
      .modal-trigger{
        display: inline-block;
        text-decoration: none;
        color: white;
        width: 90%;
        margin-left: 5%;
      }
    </style>
</head>


<body>

<?php include('../include/new_header.php'); ?>

<main style="margin-bottom: 200px;">

<div class="container center">

  <div class="row">
      <div class="col s12">
        <ul class="tabs blue-grey darken-1">
          <li class="tab col s6"><a class="active white-text" href="#test1"><?php echo $lang['myInfo']; ?></a></li>
          <li class="tab col s6"><a class="white-text" href="#test2">Emploi du temps</a></li>
        </ul>
      </div>

      <div id="test1" class="col s12">
    <div class="row">
      <form class="col s12">
        <div class="row">
          <div class="input-field col s12">
            <input id="last_name" type="text" class="validate" value="<?=$providerInfos["providerFirstName"]." ".$providerInfos["providerLastName"]?>">
            <label for="last_name"><?php echo $lang['firstName']; echo ' & '.$lang['lastName'] ?></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="last_name" type="email" class="validate" value="<?=$providerInfos["providerEmail"]?>">
            <label for="last_name"><?php echo $lang['email']; ?> :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="last_name" type="text" class="validate" value="<?=$providerInfos["providerAddress"]?>">
            <label for="last_name"><?php echo $lang['address']; ?> :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s5">
            <input id="last_name" type="text" class="validate" value="<?=$providerInfos["cityName"]?>">
            <label for="last_name"><?php echo $lang['city']; ?> :</label>
          </div>
          <div class="input-field col s2">
            <input id="last_name" type="text" class="validate" value="<?=$providerInfos["cityDepartement"]?>">
            <label for="last_name"><?php echo $lang['department']; ?> :</label>
          </div>
          <div class="input-field col s5">
            <input id="last_name" type="text" class="validate" value="<?=$providerInfos["cityRegion"]?>">
            <label for="last_name"><?php echo $lang['region']; ?> :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6">
            <input id="password" type="password" class="validate">
            <label for="password"><?php echo $lang['pwd']; ?> :</label>
          </div>
          <div class="input-field col s6">
            <input id="password" type="password" class="validate">
            <label for="password"><?php echo $lang['confirmPwd']; ?> :</label>
          </div>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="action"><?php echo $lang['edit']; ?>
          <i class="material-icons right">send</i>
        </button>

      </form>
    </div>

      </div>




      <div id="test2" class="col s12">

        <table>
        <thead>
          <tr>
              <th class="cyan lighten-5">Heure</th>
              <th class="cyan lighten-4">Lundi</th>
              <th class="cyan lighten-3">Mardi</th>
              <th class="cyan lighten-2">Mercredi</th>
              <th class="cyan lighten-1">Jeudi</th>
              <th class="cyan">Vendredi</th>
              <th class="cyan darken-1">Samedi</th>
              <th class="cyan darken-2">Dimanche</th>
          </tr>
        </thead>

        <tbody>

          <?php
          $numColor = 0;
          $idDelivery = 0;
          for ($i=0; $i < 24; $i++) {

          ?>
              <tr>

                <td class="blue lighten-5"><?=$i?>:00 - <?=$i+1?>:00</td>

                <td class="blue lighten-4">
                <?php
                $deliveryInfos = getDeliveyDayOfWeek($pdo, $idProvider, $week["monday"], $i);
                foreach ($deliveryInfos as $delivery) { ?>
                    <a class="modal-trigger <?=$color[$delivery['idDelivery']]?>" href="#modal<?=$delivery['idDelivery']?>">
                    <?php if (isFirstHour($delivery, $i) == 1) echo $delivery["serviceTitle"]." de ".$delivery["deliveryHourStart"]." à ".$delivery["deliveryHourEnd"];
                     else echo "&nbsp";?>
                  </a>
                <?php } ?>
                </td>

                <td class="blue lighten-3">
                <?php
                $deliveryInfos = getDeliveyDayOfWeek($pdo, $idProvider, $week["tuesday"], $i);
                foreach ($deliveryInfos as $delivery) { ?>
                    <a class="modal-trigger <?=$color[$delivery['idDelivery']]?>" href="#modal<?=$delivery['idDelivery']?>">
                    <?php if (isFirstHour($delivery, $i) == 1) echo $delivery["serviceTitle"]." de ".$delivery["deliveryHourStart"]." à ".$delivery["deliveryHourEnd"];
                     else echo "&nbsp";?>
                  </a>
                <?php } ?>
              </td>

                <td class="blue lighten-2">
                <?php
                $deliveryInfos = getDeliveyDayOfWeek($pdo, $idProvider, $week["wednesday"], $i);
                foreach ($deliveryInfos as $delivery) { ?>
                    <a class="modal-trigger <?=$color[$delivery['idDelivery']]?>" href="#modal<?=$delivery['idDelivery']?>">
                    <?php if (isFirstHour($delivery, $i) == 1) echo $delivery["serviceTitle"]." de ".$delivery["deliveryHourStart"]." à ".$delivery["deliveryHourEnd"];
                     else echo "&nbsp";?>
                  </a>
                <?php } ?>
                </td>

                <td class="blue lighten-1">
                <?php
                $deliveryInfos = getDeliveyDayOfWeek($pdo, $idProvider, $week["thursday"], $i);
                foreach ($deliveryInfos as $delivery) { ?>
                    <a class="modal-trigger <?=$color[$delivery['idDelivery']]?>" href="#modal<?=$delivery['idDelivery']?>">
                    <?php if (isFirstHour($delivery, $i) == 1) echo $delivery["serviceTitle"]." de ".$delivery["deliveryHourStart"]." à ".$delivery["deliveryHourEnd"];
                     else echo "&nbsp";?>
                  </a>
                <?php } ?>
                </td>

                <td class="blue">
                <?php
                $deliveryInfos = getDeliveyDayOfWeek($pdo, $idProvider, $week["friday"], $i);
                foreach ($deliveryInfos as $delivery) { ?>
                    <a class="modal-trigger <?=$color[$delivery['idDelivery']]?>" href="#modal<?=$delivery['idDelivery']?>">
                    <?php if (isFirstHour($delivery, $i) == 1) echo $delivery["serviceTitle"]." de ".$delivery["deliveryHourStart"]." à ".$delivery["deliveryHourEnd"];
                     else echo "&nbsp";?>
                  </a>
                <?php } ?>
                </td>

                <td class=" blue darken-1">
                <?php
                $deliveryInfos = getDeliveyDayOfWeek($pdo, $idProvider, $week["saturday"], $i);
                foreach ($deliveryInfos as $delivery) { ?>
                    <a class="modal-trigger <?=$color[$delivery['idDelivery']]?>" href="#modal<?=$delivery['idDelivery']?>">
                    <?php if (isFirstHour($delivery, $i) == 1) echo $delivery["serviceTitle"]." de ".$delivery["deliveryHourStart"]." à ".$delivery["deliveryHourEnd"];
                     else echo "&nbsp";?>
                  </a>
                <?php } ?>
                </td>

                <td class=" blue darken-2">
                <?php
                $deliveryInfos = getDeliveyDayOfWeek($pdo, $idProvider, $week["sunday"], $i);
                foreach ($deliveryInfos as $delivery) { ?>
                    <a class="modal-trigger <?=$color[$delivery['idDelivery']]?>" href="#modal<?=$delivery['idDelivery']?>">
                    <?php if (isFirstHour($delivery, $i) == 1) echo $delivery["serviceTitle"]." de ".$delivery["deliveryHourStart"]." à ".$delivery["deliveryHourEnd"];
                     else echo "&nbsp";?>
                  </a>
                <?php } ?>
                </td>

              </tr>

    <?php } ?>

        </tbody>
      </table>

<?php
$getDeliveryInfos = $pdo->prepare("SELECT * FROM DELIVERY INNER JOIN SERVICE ON DELIVERY.idService = SERVICE.idService WHERE idProvider = ? && deliveryDateStart >= ? && deliveryDateStart <= ?");
$getDeliveryInfos->execute([$idProvider, $week["monday"], $week["sunday"]]);
$deliveryInfos = $getDeliveryInfos->fetchAll();
foreach ($deliveryInfos as $delivery) {

  $getClientInfos = $pdo->prepare("SELECT * FROM BILL INNER JOIN USER ON BILL.idUser = USER.idUser INNER JOIN CITY ON USER.userIdCity = CITY.idCity WHERE idBill = ?");
  $getClientInfos->execute([$delivery["idBill"]]);
  $clientInfos = $getClientInfos->fetch();

 ?>

      <!-- Modal Structure -->
  <div id="modal<?=$delivery['idDelivery']?>" class="modal">
    <div class="modal-content">
      <h4><?=$delivery["serviceTitle"]?> le <?=date("d/m/Y",strtotime($delivery["deliveryDateStart"]))?></h4>
      <p>De <?=$delivery["deliveryHourStart"]?> à <?=$delivery["deliveryHourEnd"]?> heures.</p>
      <h5>Adresse :</h5>
      <p>
        Prénom & nom : <?=$clientInfos["userFirstName"]." ".$clientInfos["userLastName"]?><br>
        Adresse : <?=$clientInfos["userAddress"]?><br>
        Ville : <?=$clientInfos["cityName"]?><br>
        Département : <?=$clientInfos["cityDepartement"]?><br>
        Région : <?=$clientInfos["cityRegion"]?>
      </p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect btn red darken-3">Annuler</a>
      <a href="#!" class="modal-close waves-effect btn">Fermer</a>
    </div>
  </div>

  <?php } ?>

      </div>

  </div>


</div>



<div class="fixed-action-btn">
  <a class="btn-floating btn-large" href="../php/deconnexion.php">
    <i class="large material-icons">directions_walk</i>
  </a>
</div>



</main>

<?php include("../include/new_footer.php"); ?>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript">
  var el = document.querySelectorAll('.tabs')
  var instance = M.Tabs.init(el);

  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.fixed-action-btn');
    var instances = M.FloatingActionButton.init(elems);
  });

  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.collapsible');
    var instances = M.Collapsible.init(elems);
  });

  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems);
  });

</script>
