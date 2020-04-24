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

if (empty($_POST["dateStart"]) || empty($_POST["dateEnd"]) || empty($_POST["hourStart"]) || empty($_POST["hourEnd"])) {
  header("location: profilProvider.php?error=empty");
  exit;
}

if($_POST["dateStart"] <= date("Y-m-d", time())) {
  header("location: profilProvider.php?error=badDate");
  exit;
}

$deleteAvailabilities = $pdo->prepare("DELETE FROM DELIVERY WHERE idProvider = ? && deliveryState = 50 && (deliveryDateStart >= ? || deliveryDateStart <= ?)");
$deleteAvailabilities->execute([$idProvider, $_POST["dateStart"], $_POST["dateEnd"]]);

$date = $_POST["dateStart"];
while (strtotime($date) <= strtotime($_POST["dateEnd"])) {

  $getDelivery = $pdo->prepare("SELECT * FROM DELIVERY WHERE idProvider = ? && deliveryState != 50 && deliveryDateStart = ? && deliveryHourStart < ?");
  $getDelivery->execute([$idProvider, $date, $_POST["hourStart"]]);
  $nbDelivery = $getDelivery->rowCount();

  $getDelivery = $pdo->prepare("SELECT * FROM DELIVERY WHERE idProvider = ? && deliveryState != 50 && deliveryDateStart = ? && deliveryHourEnd > ?");
  $getDelivery->execute([$idProvider, $date, $_POST["hourEnd"]]);
  $nbDelivery += $getDelivery->rowCount();

  $getDelivery = $pdo->prepare("SELECT * FROM DELIVERY WHERE idProvider = ? && deliveryState != 50 && deliveryDateStart = ? && deliveryDateStart != deliveryDateEnd && deliveryHourEnd > ?");
  $getDelivery->execute([$idProvider, $date, $_POST["hourStart"]]);
  $nbDelivery += $getDelivery->rowCount();

  if ($nbDelivery != 0) {
    header("location: profilProvider.php?error=alreadyADelivery");
    exit;
  }

  $date = date("Y-m-d",strtotime($date."+1 day"));

}

$date = $_POST["dateStart"];
while (strtotime($date) <= strtotime($_POST["dateEnd"])) {

  $insertAvailabilitiesStart = $pdo->prepare("INSERT INTO DELIVERY (idProvider, deliveryDateStart, deliveryDateEnd, deliveryHourStart, deliveryHourEnd, deliveryState, idService) VALUES (?,?,?,?,?,50,50)");
  $insertAvailabilitiesStart->execute([$idProvider, $_POST["dateStart"], $_POST["dateStart"], "00:00:00", $_POST["hourStart"]]);

  $insertAvailabilitiesStart = $pdo->prepare("INSERT INTO DELIVERY (idProvider, deliveryDateStart, deliveryDateEnd, deliveryHourStart, deliveryHourEnd, deliveryState, idService) VALUES (?,?,?,?,?,50,50)");
  $insertAvailabilitiesStart->execute([$idProvider, $_POST["dateStart"], $_POST["dateStart"], $_POST["hourEnd"], "24:00:00"]);

  $date = date("Y-m-d", strtotime($date."+1 day"));

}

header("location: profilProvider.php?update=true")

?>
