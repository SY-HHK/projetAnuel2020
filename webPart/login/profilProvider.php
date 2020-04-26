<?php
session_start();
include("../include/config.php");
include('../include/lang.php');
if (!isset($_SESSION["provider"])) {
  header("location: ../php/deconnexion.php");
  exit;
}

$getProviderInfos = $pdo->prepare("SELECT * FROM PROVIDER INNER JOIN CITY ON providerIdCity = idCity WHERE providerGuid = ?");
$getProviderInfos->execute([$_SESSION["provider"]]);
$nbProvider = $getProviderInfos->rowCount();
if ($nbProvider == 0) {
  header("location: ../php/deconnexion.php");
  exit;
}
else {
  $providerInfos = $getProviderInfos->fetch();
  $idProvider = $providerInfos["idProvider"];
}

if (isset($_GET["day"]) && !empty($_GET["day"])) {
  $monday = date("Y-m-d", $_GET["day"]);
}
else {
  if (date("D",time()) == "Mon") $monday = date("Y-m-d",time());
  else $monday = date("Y-m-d", strtotime(date("Y-m-d",time())."last monday"));
}
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
  $getDeliveryInfosNight = $pdo->prepare("SELECT * FROM DELIVERY INNER JOIN SERVICE ON DELIVERY.idService = SERVICE.idService
    WHERE idProvider = ? && ((deliveryDateStart = ? && deliveryDateEnd = ? && deliveryHourStart < ?) || (deliveryDateStart = ? && deliveryDateEnd = ? && deliveryHourEnd > ?))
    ORDER BY deliveryHourStart ASC");
  $getDeliveryInfosNight->execute([$idProvider, $day, date("Y-m-d", strtotime($day."+1 days")), $i.":00:00", date("Y-m-d", strtotime($day."-1 days")), $day, $i.":00:00"]);
  return array_merge($getDeliveryInfos->fetchall(), $getDeliveryInfosNight->fetchAll());
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
          <li class="tab col s6"><a class="<?php if (!isset($_GET['day'])) echo 'active';?> white-text" href="#test1"><?php echo $lang['myInfo']; ?></a></li>
          <li class="tab col s6"><a class="<?php if (isset($_GET['day'])) echo 'active';?> white-text" href="#test2">Emploi du temps</a></li>
        </ul>
      </div>

      <div id="test1" class="col s12">
    <div class="row">
      <form method="post" action="../php/updateProvider.php" class="col s12">
        <div class="row">
          <div class="input-field col s12">
            <input id="name" name="name" type="text" class="validate" value="<?=$providerInfos["providerFirstName"]." ".$providerInfos["providerLastName"]?>">
            <label for="name"><?php echo $lang['firstName']; echo ' & '.$lang['lastName'] ?></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="last_name" name="email" type="email" class="validate" value="<?=$providerInfos["providerEmail"]?>">
            <label for="last_name"><?php echo $lang['email']; ?> :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="last_name" name="address" type="text" class="validate" value="<?=$providerInfos["providerAddress"]?>">
            <label for="last_name"><?php echo $lang['address']; ?> :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s5">
            <input id="cityName" name="cityName" type="text" class="validate" value="<?=$providerInfos["cityName"]?>">
            <label for="cityName"><?php echo $lang['city']; ?> :</label>
          </div>
          <div class="input-field col s2">
            <input id="cityDepartment" name="cityDepartment" type="text" class="validate" value="<?=$providerInfos["cityDepartement"]?>">
            <label for="cityDepartment"><?php echo $lang['department']; ?> :</label>
          </div>
          <div class="input-field col s5">
            <input id="cityRegion" name="cityRegion" type="text" class="validate" value="<?=$providerInfos["cityRegion"]?>">
            <label for="cityRegion"><?php echo $lang['region']; ?> :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6">
            <input id="password" name="password" type="password" class="validate">
            <label for="password"><?php echo $lang['pwd']; ?> :</label>
          </div>
          <div class="input-field col s6">
            <input id="newPassword" name="newPassword" type="password" class="validate">
            <label for="newPassword"><?php echo $lang['confirmPwd']; ?> :</label>
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
              <th class="cyan lighten-4">
                Lundi <?=date("d/m",strtotime($week["monday"]))?><br>
                <a href="profilProvider.php?day=<?=strtotime($monday."-7 days")?>" class="waves-effect waves-light btn-small"><i class="material-icons left">keyboard_arrow_left</i></a>
              </th>
              <th class="cyan lighten-3">Mardi <?=date("d/m",strtotime($week["tuesday"]))?></th>
              <th class="cyan lighten-2">Mercredi <?=date("d/m",strtotime($week["wednesday"]))?></th>
              <th class="cyan lighten-1">Jeudi <?=date("d/m",strtotime($week["thursday"]))?></th>
              <th class="cyan">Vendredi <?=date("d/m",strtotime($week["friday"]))?></th>
              <th class="cyan darken-1">Samedi <?=date("d/m",strtotime($week["saturday"]))?></th>
              <th class="cyan darken-2">
                Dimanche <?=date("d/m",strtotime($week["sunday"]))?><br>
                <a href="profilProvider.php?day=<?=strtotime($monday."+7 days")?>" class="waves-effect waves-light btn-small"><i class="material-icons left">keyboard_arrow_right</i></a>
              </th>
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

      <!-- Modal Trigger -->
  <a class="waves-effect waves-light btn-large modal-trigger  blue-grey darken-3" href="#provider" style="margin-left:0%; margin-top:20px;">Définir mes horaires</a>

  <!-- Modal Structure -->
  <div id="provider" class="modal">
    <form action="setProviderAvailabilities.php" method="post">
    <div class="modal-content">
      <div class="row">
        <h4>Définir mes horaires :</h4>
          <div class="input-field col s1">
            <p>Du :</p>
          </div>
          <div class="input-field col s2">
            <input name="dateStart" type="date" required>
          </div>
          <div class="input-field col s1">
            <p>Au :</p>
          </div>
          <div class="input-field col s2">
            <input name="dateEnd" type="date" required>
          </div>
          <div class="input-field col s1">
            <p>Début (0 = mini) :</p>
          </div>
          <div class="input-field col s2">
            <input name="hourStart" type="time" required>
          </div>
          <div class="input-field col s1">
            <p>Fin (24 = max) :</p>
          </div>
          <div class="input-field col s2">
            <input name="hourEnd" type="time" required>
          </div>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-light btn red darken-2">Annuler</a>
      <button type="submit" class="waves-effect waves-light btn">Valider</button>
    </div>
    </form>
  </div>

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
      <?php
      if ($delivery["idService"] == 1) { ?>
        <p><?=$clientInfos["billDescription"]?></p>
      <?php } ?>
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
      <?php if (strtotime($delivery["deliveryDateStart"]) > time() || (strtotime($delivery["deliveryDateStart"]) == strtotime(date("Y-m-d",time())) && strtotime($delivery["deliveryHourStart"]) >= time())) { ?>
      <a href="cancelDelivery.php?idDelivery=<?=$delivery['idDelivery']?>" class="modal-close waves-effect btn red darken-3">Annuler</a>
      <?php } ?>
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

  <?php if (isset($_GET["error"]) && !empty($_GET["error"])) {
    if ($_GET["error"] == "cancel") { ?>
      M.toast({html: 'Vous venez d\'annuler une intervention, attention à ne pas trop en annuler !'});
  <?php } } ?>

</script>
