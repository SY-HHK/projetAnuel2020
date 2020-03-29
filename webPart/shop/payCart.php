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
require_once "../vendor/autoload.php";

function decimalHours($time)
{
    $hms = explode(":", $time);
    $time = ($hms[0] + ($hms[1]/60));
    return round($time, 2);
}

$time = 0;
$totalPrice = 0;
$description = "";
$i = 1;
while (isset($_POST["serviceTitle".$i])) {
  $time = decimalHours($_POST["timeStop".$i]) - decimalHours($_POST["timeStart".$i]);
  $description = $description."Service de ".$_POST["serviceTitle".$i]." : "
                .$time." heures le ".date("d/m/yy", strtotime($_POST["date".$i])).", ";

  //get service price from db
  $price = $pdo->prepare("SELECT servicePrice FROM SERVICE WHERE serviceTitle = ?");
  $price->execute([$_POST["serviceTitle".$i]]);
  $price = $price->fetch();
  $totalPrice += ($price["servicePrice"] * $time);
  $i++;
}
$totalPrice = strval(round($totalPrice, 2));

$getIdUser = $pdo->prepare("SELECT idUser FROM USER WHERE userGuid = ?");
$getIdUser->execute([$_SESSION["user"]]);
$getIdUser = $getIdUser->fetch();
$idUser = $getIdUser["idUser"];

$insertNewBill = $pdo->prepare("INSERT INTO BILL (idUser, billDate, billDescription, billPrice, billState) VALUES (?,now(),?,?,?)");
$insertNewBill->execute([$idUser, $description, $totalPrice, 0]);
$idBill = $pdo->lastInsertId();

//conversion for amount type of stripe api
$totalPrice = explode(".", $totalPrice);
$totalPrice = $totalPrice[0].$totalPrice[1];

\Stripe\Stripe::setApiKey('sk_test_9bT77JdwRJaBD1Mn0YJj1Zb600k6QROR7E');

$session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'name' => 'Service(s) BringMe.com',
    'description' => $description,
    //'images' => [''],
    'amount' => $totalPrice,
    'currency' => 'eur',
    'quantity' => 1,
  ]],
  "client_reference_id" => $idBill,
  'customer_email' => $_SESSION['userEmail'],
  'success_url' => 'http://localhost/projetAnuel2020/webPart/shop/payment.php?session_id={CHECKOUT_SESSION_ID}',
  'cancel_url' => 'http://localhost/projetAnuel2020/webPart/shop/catalog.php?error=cancel',
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

   setTimeout(function(){ buy() }, 3000);

  </script>
</html>
