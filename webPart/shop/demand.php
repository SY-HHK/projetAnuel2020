<?php
include ('../include/lang.php');
session_start();

if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
  header("location: ../login/connexion.php?error=plz_login");
  exit;
}
if (!isset($_POST["title"]) || !isset($_POST["date"]) || !isset($_POST["hourStart"]) || !isset($_POST["description"])) {
  header("location: catalog.php?error=missing_fields");
  exit;
}
if (strtotime($_POST["date"]) < time()) {
  header("location: catalog.php?error=date");
  exit;
}
include("../include/config.php");
require_once "../vendor/autoload.php";

$getIdUser = $pdo->prepare("SELECT idUser FROM USER WHERE userGuid = ?");
$getIdUser->execute([$_SESSION["user"]]);
$getIdUser = $getIdUser->fetch();
$idUser = $getIdUser["idUser"];

$insertNewBill = $pdo->prepare("INSERT INTO BILL (idUser, billDate, billDescription, billState) VALUES (?,now(),?,2)");
$insertNewBill->execute([$idUser, $_POST["description"]]);
$idBill = $pdo->lastInsertId();

if (isset($_POST["hourStop"]) && !empty($_POST["hourStop"])) $timeStop = $_POST["hourStop"];
else $timeStop = NULL;

if ($_POST["hourStart"] > $_POST["hourStop"]) {
  $dateEnd = date("Y-m-d", strtotime($_POST["date"]."+ 1 days"));
}
else {
  $dateEnd = $_POST["date"];
}

$insertNewDelivery = $pdo->prepare("INSERT INTO delivery (deliveryDateStart, deliveryDateEnd, deliveryHourStart, deliveryHourEnd, deliveryState, idService, idBill) VALUES (?,?,?,?,?,?,?)");
$insertNewDelivery->execute([$_POST["date"], $dateEnd, $_POST["hourStart"], $timeStop, 2, 1, $idBill]);

header("location: ../login/profilUser.php?shop=yes");

?>
