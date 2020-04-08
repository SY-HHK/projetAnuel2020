<?php
session_start();

if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
  header("location: ../login/connexion.php?error=plz_login");
  exit;
}
if (!isset($_POST["title"]) || !isset($_POST["date"]) || !isset($_POST["timeStart"]) || !isset($_POST["description"])) {
  header("location: catalog.php?error=missing_fields");
  exit;
}
include("../include/config.php");
require_once "../vendor/autoload.php";

$getIdUser = $pdo->prepare("SELECT idUser FROM USER WHERE userGuid = ?");
$getIdUser->execute([$_SESSION["user"]]);
$getIdUser = $getIdUser->fetch();
$idUser = $getIdUser["idUser"];

$insertNewBill = $pdo->prepare("INSERT INTO BILL (idUser, billDate, billDescription, billState) VALUES (?,now(),?,3)");
$insertNewBill->execute([$idUser, $_POST["description"]]);
$idBill = $pdo->lastInsertId();

$insertNewDemand = $pdo->prepare("INSERT INTO service (serviceTitle, serviceDescription, serviceValidate, idUser) VALUES (?,?,0,?)");
$insertNewDemand->execute([$_POST["title"], $_POST["description"], $idUser]);
$idDemand = $pdo->lastInsertId();

if (isset($_POST["timeStop"]) && !empty($_POST["timeStop"])) $timeStop = $_POST["timeStop"];
else $timeStop = NULL;

if (isset($_POST["endTomorow"])) {
  $dateEnd = date_create($_POST["date"]);
  date_add($dateEnd, date_interval_create_from_date_string('1 days'));
  $dateEnd = date_format($dateEnd, "yy-m-d");
}
else $dateEnd = $_POST["date"];

$insertNewDelivery = $pdo->prepare("INSERT INTO delivery (deliveryDateStart, deliveryDateEnd, deliveryHourStart, deliveryHourEnd, deliveryState, idService, idBill) VALUES (?,?,?,?,?,?,?)");
$insertNewDelivery->execute([$_POST["date"], $dateEnd, $_POST["timeStart"], $timeStop, 0, $idDemand, $idBill]);

header("location: ../login/profilUser.php?shop=yes");


?>
