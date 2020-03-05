<?php
require_once "vendor/autoload.php";


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
      echo "votre achat a réussi !";
      $i = 1;
    }
  }

  if ($i == 0) {
    echo "Votre achat n'a pas abouti !";
  }

?>
