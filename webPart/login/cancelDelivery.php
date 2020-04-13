<?php
session_start();
include("../include/config.php");
include("../shop/FindProvider.php");
include('../include/lang.php');
if (!isset($_SESSION["provider"])) {
  //header("location: ../php/deconnexion.php");
  exit;
}

$getDeliveryInfos = $pdo->prepare("SELECT * FROM DELIVERY INNER JOIN PROVIDER ON DELIVERY.idProvider = Provider.idProvider INNER JOIN SERVICE ON DELIVERY.idService = SERVICE.idService WHERE providerGuid = ? && idDelivery = ?");
$getDeliveryInfos->execute([$_SESSION["provider"], $_GET["idDelivery"]]);
$nbDelivery = $getDeliveryInfos->rowCount();
if ($nbDelivery == 0) {
  header("location: ../php/deconnexion.php");
  exit;
}
else {
  $delivery = $getDeliveryInfos->fetch();
  $idProvider = $delivery["idProvider"];
}

$getUserInfos = $pdo->prepare("SELECT * FROM USER INNER JOIN BILL ON BILL.idUser = USER.idUser WHERE idBill = ?");
$getUserInfos->execute([$delivery["idBill"]]);
$userInfos = $getUserInfos->fetch();

$formattedDelivery = array(
  "date" => $delivery["deliveryDateStart"],
  "hourStart" => $delivery["deliveryHourStart"],
  "hourStop" => $delivery["deliveryHourEnd"],
  "idService" => $delivery["idService"],
  "serviceTitle" => $delivery["serviceTitle"],
);

$cancelDelivery = new FindProvider($formattedDelivery, $pdo);

if ($cancelDelivery->checkProvider("", $userInfos["userIdCity"]) == 0) {

  $updateDelivery = $pdo->prepare("UPDATE DELIVERY SET idProvider = NULL WHERE idDelivery = ?");
  $updateDelivery->execute([$delivery["idDelivery"]]);

  $updateBill = $pdo->prepare("UPDATE BILL SET billState = 4 WHERE idBill = ?");
  $updateBill->execute([$delivery["idBill"]]);

  $updateProvider = $pdo->prepare("UPDATE PROVIDER SET providerAnnulation = providerAnnulation + 1 WHERE idProvider = ?");
  $updateProvider->execute([$idProvider]);

  header("location: profilProvider.php?error=cancel");
  exit;
}
else {
  $cancelDelivery->insertDelivery("", $delivery["idBill"], $userInfos["userIdCity"]);

  $deleteDelivery = $pdo->prepare("DELETE FROM DELIVERY WHERE idDelivery = ?");
  $deleteDelivery->execute([$delivery["idDelivery"]]);
  header("location: profilProvider.php?error=cancel");
  exit;
}

?>
