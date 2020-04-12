<?php
session_start();
require_once "../vendor/autoload.php";
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

function getTimeOfDelivery($start, $stop) {
  if(strtotime($stop) < strtotime($stop)) {
    $time = 24 - decimalHours($start) + decimalHours($stop);
  }
  else {
    $time = decimalHours($stop) - decimalHours($start);
  }

 return $time;
}

function decimalHours($time) {
    $hms = explode(":", $time);
    $time = ($hms[0] + ($hms[1]/60));
    return round($time, 2);
}

if (isset($_GET["sub"]) && $_GET["sub"] == 1) {
  $getDeliveryInfos = $pdo->prepare("SELECT deliveryHourStart, deliveryHourEnd FROM DELIVERY WHERE idBill = ?");
  $getDeliveryInfos->execute([$_GET["idBill"]]);
  $deliveryInfos = $getDeliveryInfos->fetch();
  $time = getTimeOfDelivery($deliveryInfos["deliveryHourStart"], $deliveryInfos["deliveryHourEnd"]);

  if ($userInfos["subHourLeft"] >= $time) {
    $updateHourLeft = $pdo->prepare("UPDATE USER SET subHourLeft = subHourLeft - ? WHERE idUser = ?");
    $updateHourLeft->execute([$time, $userInfos["idUser"]]);

    $updateBill = $pdo->prepare("UPDATE BILL SET billState = 1, billDescription = concat(billDescription, ?) WHERE idBill = ?");
    $updateBill->execute([$_GET["idBill"], "(payer avec l'abonnement)."]);

    header("location: profilUser.php?shop=yes");
    exit;
  }
  else {
    header("location: profilUser.php?shop=noEnoughtHours");
    exit;
  }
}

$getBillInfos = $pdo->prepare("SELECT * FROM BILL WHERE idBill = ?");
$getBillInfos->execute([$_GET["idBill"]]);
$billInfos = $getBillInfos->fetch();

\Stripe\Stripe::setApiKey('sk_test_9bT77JdwRJaBD1Mn0YJj1Zb600k6QROR7E');

$session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'name' => 'Service(s) BringMe.com',
    'description' => $billInfos["billDescription"],
    //'images' => [''],
    'amount' => round($billInfos["billPrice"], 2) * 100,
    'currency' => 'eur',
    'quantity' => 1,
  ]],
  "client_reference_id" => $billInfos["idBill"],
  'customer_email' => $_SESSION['userEmail'],
  'success_url' => 'http://localhost/projetAnuel2020/webPart/login/payment.php?session_id={CHECKOUT_SESSION_ID}',
  'cancel_url' => 'http://localhost/projetAnuel2020/webPart/login/payment.php?session_id={CHECKOUT_SESSION_ID}',
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
