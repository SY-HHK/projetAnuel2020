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

// Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('sk_test_9bT77JdwRJaBD1Mn0YJj1Zb600k6QROR7E');

$events = \Stripe\Event::all([
  'type' => 'checkout.session.completed',
  'created' => [
    // Check for events created in the last hour.
    'gte' => time() - 60 * 60,
  ],
]);
$i = 0;
foreach ($events->autoPagingIterator() as $event) {
  $session = $event->data->object;

  if ($_GET["session_id"] == $session->id) {
    $bill = $pdo->prepare("UPDATE BILL SET billState = 1, billStripeId = ? WHERE idBill = ?");
    $bill->execute([$_GET["session_id"] ,$session->client_reference_id]);
    header("location: ../login/profilUser.php?shop=yes");
    exit;
  }
}

header("location: profilUser.php?shop=unconfirmed");

?>
