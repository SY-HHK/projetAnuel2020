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
else $userInfos = $getUserInfos->fetch();

$cancelBill = $pdo->prepare("DELETE FROM BILL WHERE idBill = ? && idUser = ?");
$cancelBill->execute([$_GET["idBill"], $userInfos["idUser"]]);

$cancelDelivery = $pdo->prepare("DELETE FROM DELIVERY WHERE idBill = ?");
$cancelDelivery->execute([$_GET["idBill"]]);

header("location: profilUser.php?shop=succesfullyCanceled");

?>
