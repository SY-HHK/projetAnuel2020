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

$getBillInfos = $pdo->prepare("SELECT * FROM DELIVERY INNER JOIN DELIVERY ON DELIVERY.idBill = BILL.idBill INNER JOIN SERVICE ON SERVICE.idService = DELIVERY.idService WHERE idBill = ?");
$getBillInfos->execute([$_GET["idBill"]]);
$billInfos = $getBillInfos->fetch();

$description = $billInfos["billDescription"]." => Pour cette demande, ".$time." heures à ".$billInfos["servicePrice"]."€ jugé(s) nécéssaire(s) par le service client pour son accomplissement."

\Stripe\Stripe::setApiKey('sk_test_9bT77JdwRJaBD1Mn0YJj1Zb600k6QROR7E');

$session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'name' => 'Service(s) BringMe.com',
    'description' => $billInfos["billDescription"],
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
