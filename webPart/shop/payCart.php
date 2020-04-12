<?php
session_start();
if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
  header("location: ../login/connexion.php?error=plz_login");
  exit;
}
if (!isset($_POST["serviceTitle1"])) {
  header("location: catalog.php?error=nothingInCart");
  exit;
}
include("../include/config.php");
require_once "FindProvider.php";
require_once "../vendor/autoload.php";

$getInfosUser = $pdo->prepare("SELECT * FROM USER WHERE userGuid = ?");
$getInfosUser->execute([$_SESSION["user"]]);
$getInfosUser = $getInfosUser->fetch();
$idUser = $getInfosUser["idUser"];
$subHourLeft = $getInfosUser["subHourLeft"];

$bookList = new FindProvider($_POST, $pdo);

if (isset($_POST["quoteButton"])) {
  $billInfos = $bookList->insertBill($idUser);
  $i = 1;
  while (isset($_POST["serviceTitle".$i])) {
    $insertNewDelivery = $pdo->prepare("INSERT INTO DELIVERY (idService, deliveryHourStart, deliveryHourEnd, idBill, deliveryState) VALUES (?,?,?,?,-1)");
    $insertNewDelivery->execute([$_POST["idService".$i], $_POST["hourStart".$i], $_POST["hourStop".$i], $billInfos["idBill"]]);
    $i++;
  }
  header("location: ../pdfGenerator.php?idBill=".$billInfos["idBill"]);
  exit;
}

$i = 1;
while (isset($_POST["serviceTitle".$i])) {

////////////////////////////check form
  if (empty($_POST["date".$i]) || empty($_POST["hourStart".$i]) || empty($_POST["hourStop".$i])) {
    header("location: catalog.php?error=empty");
    exit;
  }
  if (strtotime($_POST["date".$i]) < time()) {
    header("location: catalog.php?error=date");
    exit;
  }

  $time = $bookList->getTimeOfDelivery($i);
  if ($time == -1) {
    header("location: catalog.php?error=noEnoughtHours");
    exit;
  }

  if ($bookList->checkProvider($i, $getInfosUser["userIdCity"]) == 0) {
    header("location: catalog.php?error=noProvider");
    exit;
  }
$i++;
}

if ($bookList->checkSub($idUser) == 0) {
  header("location: catalog.php?error=noEnoughtSub");
  exit;
}
if ($bookList->checkSub($idUser) == -1) {
  header("location: catalog.php?error=noAvailibleSub");
  exit;
}

$billInfos = $bookList->insertBill($idUser);

$i = 1;
while (isset($_POST["serviceTitle".$i])) {
  $bookList->insertDelivery($i, $billInfos["idBill"], $getInfosUser["userIdCity"]);
  $i++;
}

if ($billInfos["totalPrice"] == 0) {
  $updateBill = $pdo->prepare("UPDATE BILL SET billState = 1 WHERE idBill = ?");
  $updateBill->execute([$billInfos["idBill"]]);

  header("location: ../login/profilUser.php?shop=yes");
  exit;
}

\Stripe\Stripe::setApiKey('sk_test_9bT77JdwRJaBD1Mn0YJj1Zb600k6QROR7E');

$session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'name' => 'Service(s) BringMe.com',
    'description' => $billInfos["description"],
    //'images' => [''],
    'amount' => round($billInfos["totalPrice"], 2) * 100,
    'currency' => 'eur',
    'quantity' => 1,
  ]],
  "client_reference_id" => $billInfos["idBill"],
  'customer_email' => $_SESSION['userEmail'],
  'success_url' => 'http://localhost/projetAnuel2020/webPart/shop/payment.php?session_id={CHECKOUT_SESSION_ID}',
  'cancel_url' => 'http://localhost/projetAnuel2020/webPart/shop/payment.php?session_id={CHECKOUT_SESSION_ID}',
  "metadata"=> ["subHourUsed" => $billInfos["subHourUsed"], "idUser" => $idUser],
]);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Payer avec stripe</title>
  </head>
  <body>

    <center><h3>Vous allez être redirigé vers stripe pour le paiement</h3><br>
      <button type="button" onclick="buy()">OK</button></center>

  </body>
  <script src="https://js.stripe.com/v3/"></script>
  <script src="jquery.js"></script>
  <script type="text/javascript">
  var stripe = Stripe("pk_test_2Nm9mC8Kbr9BA2kBP6kOcEhM00yrbTJf1D");

  function buy() {
    stripe.redirectToCheckout({
      // Make the id field from the Checkout Session creation API response
      // available to this file, so you can provide it as parameter here
      // instead of the {{CHECKOUT_SESSION_ID}} placeholder.
    sessionId: '<?php echo $session->id; ?>'
    }).then(function (result) {
    // If `redirectToCheckout` fails due to a browser or network
    // error, display the localized error message to your customer
    // using `result.error.message`..
    });
  }

   setTimeout(function(){ buy() }, 500);

  </script>
</html>
