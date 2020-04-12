<?php
session_start();
if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
  header("location: ../login/connexion.php?error=plz_login");
  exit;
}
include("../include/config.php");
require_once "../vendor/autoload.php";


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

  $eventNotPaid = \Stripe\Checkout\Session::retrieve($_GET["session_id"]);

  $cancelDelivery = $pdo->prepare("DELETE FROM DELIVERY WHERE idBill = ?");
  $cancelDelivery->execute([$eventNotPaid->client_reference_id]);

  $cancelBill = $pdo->prepare("DELETE FROM BILL WHERE idBill = ?");
  $cancelBill->execute([$eventNotPaid->client_reference_id]);

  $updateHourLeft = $pdo->prepare("UPDATE USER SET subHourLeft = subHourLeft + ? WHERE idUser = ?");
  $updateHourLeft->execute([$eventNotPaid->metadata->subHourUsed,$eventNotPaid->metadata->idUser]);

header("location: catalog.php?error=unconfirmed");

?>
