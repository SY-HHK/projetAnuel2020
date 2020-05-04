<?php
session_start();
ob_start();
require __DIR__.'/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
include("include/config.php");

$getInfosUser = $pdo->prepare("SELECT * FROM USER INNER JOIN CITY ON USER.userIdCity = CITY.idCity WHERE userGuid = ?");

if (isset($_SESSION['admin']) && isset($_GET['userGuid']) && !empty($_GET['userGuid'])){
    $getInfosUser->execute([$_GET['userGuid']]);
}else {
    $getInfosUser->execute([$_SESSION["user"]]);
}

if ($getInfosUser->rowCount() != 1) {
     header("location: index.php");
     exit;
}

$infosUser = $getInfosUser->fetch();
$idUser = $infosUser["idUser"];

$getInfosBill = $pdo->prepare("SELECT * FROM BILL WHERE idBill = ? && idUser = ?");
$getInfosBill->execute([$_GET["idBill"], $idUser]);
if ($getInfosBill->rowCount() != 1) {
  header("location: index.php");
  exit;
}
$infosBill = $getInfosBill->fetch();
if ($infosBill["billState"] != 1) $type = "Devis";
else $type = "Facture";

function decimalHours($time) {
    $hms = explode(":", $time);
    $time = ($hms[0] + ($hms[1]/60));
    return round($time, 2);
}

function getTimeOfDelivery($hourStart, $hourStop) {
  if(strtotime($hourStop) < strtotime($hourStart)) {
    $time = 24 - $this->decimalHours($hourStart) + decimalHours($hourStop);
  }
  else {
    $time = decimalHours($hourStop) - decimalHours($hourStart);
  }

  return $time;
}
?>

<style media="screen">
#price th {
  width: 100px;
  border: 1px solid black;
}

#price table {
  border: 1px solid black;
}

#price {
  width: 80%;
  margin-left: 10%;
  margin-top: 40px;
}

#tableTotal {
  margin-left: 73%;
  margin-top: 10px;
}

#header {
  display: inline;
  width: 75%;
}

img {
  display: inline;
  width: 25%;
}

#client th {
  width: 450px;
  font-weight: normal;
}

#conditions {
  font-size: 9px;
  margin-left: 150px;
}
</style>

<div style="margin-bottom: 20px;">
<div id="header">
<h3>BringMe</h3>
242 Rue du Faubourg Saint-Antoine <br>
75012 Paris <br>
0660762384 <br>
BringMe.com
</div>
<img src="images/logo.png">
</div>

<table id="client">
<tr>
  <th>
    Numéro de facture : <?=$infosBill["idBill"]?><br>
    Date : <?=$infosBill["billDate"]?><br>
    Numéro de client : <?=$infosUser["userGuid"]?>
  </th>
  <th>
    <?=$infosUser["userFirstName"]." ".$infosUser["userLastName"]?><br>
    <?=$infosUser["userAddress"]?><br>
    <?=$infosUser["cityName"]."(".$infosUser["cityDepartement"]."), ".$infosUser["cityRegion"]?>
  </th>
</tr>
</table>

<div id="price">

  <div style="margin-left: 30%;"><h2><?=$type?> du <?=date("d/m/yy", strtotime($infosBill["billDate"]))?></h2></div>

  <table style="padding-bottom: 100px;">
        <thead>
          <tr>
              <th>Quantité</th>
              <th style="width: 300px;">Désignation</th>
              <th>Prix unitaire HT</th>
              <th>Prix total HT</th>
          </tr>
        </thead>

        <tbody>

<?php

$getDelivery = $pdo->prepare("SELECT * FROM DELIVERY INNER JOIN SERVICE on DELIVERY.idService = SERVICE.idService WHERE idBill = ?");
$getDelivery->execute([$_GET["idBill"]]);
$deliverys = $getDelivery->fetchAll();

foreach ($deliverys as $delivery) {

?>
          <tr>
            <td><?=getTimeOfDelivery($delivery["deliveryHourStart"], $delivery["deliveryHourEnd"])?> heures</td>
            <td><?=$delivery["serviceTitle"]?></td>
            <td><?=$delivery["servicePrice"]?></td>
            <td><?=round($delivery["servicePrice"] * getTimeOfDelivery($delivery["deliveryHourStart"], $delivery["deliveryHourEnd"]), 2)?></td>
          </tr>

<?php } ?>

        </tbody>
      </table>

      <table id="tableTotal">
        <tr>
          <td>Total Hors taxe</td>
          <td><?=$infosBill["billPrice"] * 0.8?>€</td>
        </tr>
        <tr>
          <td>TVA à 20%</td>
          <td><?=$infosBill["billPrice"] * 0.2?>€</td>
        </tr>
        <tr>
          <td>Total TTC en euros</td>
          <td><?=$infosBill["billPrice"]?>€</td>
        </tr>
      </table>

</div>

<div style="margin-left: 10%; margin-top: 30px; margin-right: 10%;">

  <?=$infosBill["billDescription"]?>

</div>

<page_footer>
  <p id="conditions">Réglement par carte bancaire à l'aide de la plateforme Stripe. Pour plus d'informations voir les conditions d'utilisations.</p>
</page_footer>




<?php
$content = ob_get_clean();
try{
  $pdf = new HTML2PDF('P', 'A4', 'fr');
  $pdf->pdf->SetDisplayMode('fullpage');
  $pdf->writeHTML($content);
  $pdf->Output('Facture.pdf'); //nom du fichier pdf
} catch(HTML2PDF_exception $e) {
  die($e);
}

if ($infosBill["billState"] == 0) {
  $cancelDelivery = $pdo->prepare("DELETE FROM DELIVERY WHERE idBill = ?");
  $cancelDelivery->execute([$_GET["idBill"]]);

  $cancelBill = $pdo->prepare("DELETE FROM BILL WHERE idBill = ?");
  $cancelBill->execute([$_GET["idBill"]]);
}
?>
