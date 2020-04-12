<?php
include('../../include/config.php');



if (isset($_POST['enregistrer'])){


	$state = $_POST['state'];
	$description = $_POST['description'];
    $dateStart = $_POST['dateStart'];
    $hourStart = $_POST['hourStart'];
    $hourEnd = $_POST['hourEnd'];
    $dateEnd = $_POST['dateEnd'];
    $service = $_POST['idService'];
    $idDelivery = $_POST['idDelivery'];
    $idBill = $_POST['idBill'];


    echo ($state .$description .$service.$idDelivery.$idBill);

	
if ($state == 1) {

    if (!isset($hourEnd) || empty($hourEnd)){
        header('Location: ../request.php?error=hourEnd');
        exit;
    }

    if (!isset($dateEnd) || empty($dateEnd) || $dateEnd < $dateStart){
        header('Location: ../request.php?error=dateEnd');
        exit;
    }

	$queryUpdate = $pdo->prepare('UPDATE DELIVERY, BILL SET
		DELIVERY.deliveryDateStart = :dateStart,
		DELIVERY.deliveryDateEnd = :dateEnd,
		DELIVERY.deliveryHourStart = :hourStart,
		DELIVERY.deliveryState = :newState,
		DELIVERY.idService = :service,
		DELIVERY.deliveryHourEnd = :hourEnd,
		BILL.billDescription = :description
		WHERE idDelivery = :idDelivery AND BILL.idBill = :idBill');


	$queryUpdate->execute(array(
	'idBill' => $idBill,
	'idDelivery' => $idDelivery,
	'dateStart'=> $dateStart,
	'dateEnd' => $dateEnd,
	'hourStart' => $hourStart,
	'newState' => 0,
	'service' => $service,
	'hourEnd' => $hourEnd,
	'description' => htmlspecialchars($description)
	));

	$rows = $queryUpdate->rowCount();

	if ($rows == 1){
   		header('location: ../history.php?request='.$rows);
        exit;
  	} else {
    	header('location: ../request.php');
        exit;
  	}
  } else {


  	$queryUpdate = $pdo->prepare('UPDATE DELIVERY SET
		deliveryState = :newState
		WHERE idDelivery = :id');


	$queryUpdate->execute(array(
	'id' => $idDelivery,
	'newState' => 3
	));

	$rows = $queryUpdate->rowCount();

   	if ($rows == 1){
   		header('location: ../request.php?request='.$rows);
        exit;
  	} else {
    	header('location: ../request.php');
        exit;
  	}

  }

}

?>