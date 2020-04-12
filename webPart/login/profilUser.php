<?php
session_start();
include("../include/config.php");
include('../include/lang.php');
if (!isset($_SESSION["user"])) {
  header("../location: index.php");
  exit;
}

$getUserInfos = $pdo->prepare("SELECT * FROM USER WHERE userGuid = ?");
$getUserInfos->execute([$_SESSION["user"]]);
$nbUser = $getUserInfos->rowCount();
if ($nbUser == 0) {
  header("location: ../php/deconnexion.php");
  exit;
}
else {
  $userInfos = $getUserInfos->fetch();
  $idUser = $userInfos["idUser"];

  $getUserCity = $pdo->prepare("SELECT * FROM CITY WHERE idCity = ?");
  $getUserCity->execute([$userInfos["userIdCity"]]);
  $userCity = $getUserCity->fetch();

  $userInfos = array_merge($userInfos, $userCity);

  if (!empty($userInfos["idSubscription"])) {
    if (strtotime(date("Y-m-d")) < strtotime($userInfos['subEnd'])) {
      $getSubInfos = $pdo->prepare("SELECT subName FROM SUBSCRIPTION WHERE idSub = ?");
      $getSubInfos->execute([$userInfos["idSubscription"]]);
      $subInfos = $getSubInfos->fetch();

      $userInfos = array_merge($userInfos, $subInfos);
    }
  }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lang['titleProfile']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
</head>


<body>

<?php include('../include/new_header.php'); ?>

<main style="margin-bottom: 200px;">

<div class="container center">

  <div class="row">
      <div class="col s12">
        <ul class="tabs blue-grey darken-1">
          <li class="tab col s6"><a class="active white-text" href="#test1"><?php echo $lang['myInfo']; ?></a></li>
          <li class="tab col s6"><a class="white-text" href="#test2"><?php echo $lang['myOrders']; ?></a></li>
        </ul>
      </div>

      <div id="test1" class="col s12">
    <div class="row">
      <form class="col s12">
        <div class="row">
          <div class="input-field col s12">
            <input id="last_name" type="text" class="validate" value="<?=$userInfos["userFirstName"]." ".$userInfos["userLastName"]?>">
            <label for="last_name"><?php echo $lang['firstName']; echo ' & '.$lang['lastName'] ?></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="last_name" type="email" class="validate" value="<?=$userInfos["userEmail"]?>">
            <label for="last_name"><?php echo $lang['email']; ?> :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="last_name" type="text" class="validate" value="<?=$userInfos["userAddress"]?>">
            <label for="last_name"><?php echo $lang['address']; ?> :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s5">
            <input id="last_name" type="text" class="validate" value="<?=$userInfos["cityName"]?>">
            <label for="last_name"><?php echo $lang['city']; ?> :</label>
          </div>
          <div class="input-field col s2">
            <input id="last_name" type="text" class="validate" value="<?=$userInfos["cityDepartement"]?>">
            <label for="last_name"><?php echo $lang['department']; ?> :</label>
          </div>
          <div class="input-field col s5">
            <input id="last_name" type="text" class="validate" value="<?=$userInfos["cityRegion"]?>">
            <label for="last_name"><?php echo $lang['region']; ?> :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input disabled id="last_name" type="text" class="validate" value="<?php if (isset($userInfos['subName'])) echo $userInfos['subName'].' '.$lang['to'].' '.date('d-m-Y',strtotime($userInfos['subEnd']))
            .' ('.$userInfos['subHourLeft']." ".$lang['hourLeft'].')'; else echo $lang['no'];?>">
            <label for="last_name"><?php echo $lang['sub']; ?> :</label>
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

        <ul class="collapsible">

          <?php

            $getAllbills = $pdo->prepare("SELECT * FROM BILL WHERE idUser = ? && billState != 0 ORDER BY billDate DESC");
            $getAllbills->execute([$idUser]);
            $bills = $getAllbills->fetchAll();
            foreach ($bills as $bill) { ?>

          <li>
            <div class="collapsible-header"><i class="material-icons">chevron_right</i>
              Commande du <?=date("d/m/yy", strtotime($bill["billDate"]))?> pour <?php if (!empty($bill["billPrice"])) echo $bill["billPrice"]."€ "; else echo "0€";?>
              .
              <?php if ($bill["billState"] == 1) { ?>
              <a class="waves-effect waves-light btn col s3" target="_blank" href="../pdfGenerator.php?idBill=<?=$bill["idBill"]?>">Facture</a>
              <?php } ?>
              <?php if ($bill["billState"] == 3) { ?>
              <a class="waves-effect waves-light btn col s2" target="_blank" href="../pdfGenerator.php?idBill=<?=$bill["idBill"]?>">Devis</a>
              <a class="waves-effect waves-light btn col s2" target="_blank" href="payment.php?idBill=<?=$bill["idBill"]?>">Payer</a>
              <a class="waves-effect waves-light btn col s2 red darken-2" href="cancelBill.php?idBill=<?=$bill["idBill"]?>">Annuler</a>
              <?php } ?>
              <?php if ($bill["billState"] == 2) { ?>
              Demande en cours d'étude.
              <a class="waves-effect waves-light btn col s2 red darken-2" href="cancelBill.php?idBill=<?=$bill["idBill"]?>">Annuler</a>
              <?php } ?>
            </div>
            <div class="collapsible-body"><span>

              <?=$bill["billDescription"]?>
              <?php
              if ($bill["billState"] != 2) {
                $getDeliveryInfos = $pdo->prepare("SELECT * FROM DELIVERY INNER JOIN PROVIDER ON DELIVERY.idProvider = PROVIDER.idProvider INNER JOIN SERVICE ON DELIVERY.idService = SERVICE.idService WHERE idBill = ?");
                $getDeliveryInfos->execute([$bill["idBill"]]);
                $deliveryInfos = $getDeliveryInfos->fetchAll();
                foreach ($deliveryInfos as $delivery) { ?>

                  <p>Le <?=date("d/m/Y", strtotime($delivery["deliveryDateStart"]))?>, <?=$delivery["providerFirstName"]?> de la société <?=$delivery["companyName"]?>
                    <?php if (strtotime($delivery["deliveryDateStart"]) > time()) echo "effectuera"; else echo "a effectué"; ?>
                    le service <?=$delivery["serviceTitle"]?> de <?=$delivery["deliveryHourStart"]?> à <?=$delivery["deliveryHourEnd"]?> heures.</p>

              <?php  }
              }
              ?>

            </span></div>
          </li>

          <?php } ?>

        </ul>

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


  <?php if (isset($_GET["shop"]) && !empty($_GET["shop"])) {
    if ($_GET["shop"] == "yes") { ?>
      M.toast({html: 'Votre réservation a été effectuée. Pour plus d\'information consultez l\'onglet \'mes commandes\''});
  <?php } } ?>

</script>
