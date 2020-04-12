<?php
include ('../include/lang.php');
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
      // Check for events created in the last 24 hours.
      'gte' => time() - 60 * 60,
    ],
  ]);
  $i = 0;
  foreach ($events->autoPagingIterator() as $event) {
    $session = $event->data->object;

    if ($_GET["session_id"] == $session->id) {
      $getInfosSub = $pdo->prepare("SELECT * FROM SUBSCRIPTION WHERE subStripeId = ?");
      $getInfosSub->execute([$session["display_items"][0]->plan->id]);
      $infosSub = $getInfosSub->fetch();
      $idSub = $infosSub["idSub"];
      $hourSub = $infosSub["subHour"];

      $dateStart = new DateTime();
      $dateEnd = new DateTime("+1 year");

      $addSub = $pdo->prepare("UPDATE USER SET idSubscription = ?, subStart = ?, subEnd = ?, subHourLeft = ? WHERE userEmail = ?");
      $addSub->execute([$idSub, $dateStart->format("Y-m-d"), $dateEnd->format("Y-m-d"), $hourSub, $session["customer_email"]]);
      header("location: ../login/profilUser.php?shop=sub");
      exit;
    }
  }

header("location: subPrice.php?error=unconfirmed");

?>
