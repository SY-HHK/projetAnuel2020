<?php
session_start();
ob_start();
require __DIR__.'/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
include("include/config.php");
$getInfosUser = $pdo->prepare("SELECT * FROM USER WHERE userGuid = ?");
$getInfosUser->execute([$_SESSION["user"]]);
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
if ($infosBill["billState"] == 0) $type = "Devis";
else $type = "Facture";
?>

<img src="images/logo.png" style="width: 30%;">

<div style="width: 80%; margin-left: 10%;">

  <div style="margin-left: 30%;"><h2><?=$type?> du <?=date("d/m/yy", strtotime($infosBill["billDate"]))?></h2></div>

  <p>Prix : <?=$infosBill["billPrice"]?>€</p>

  <p>Description : <?=str_replace(",", "\n", $infosBill["billDescription"])?></p>

</div>





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
?>
