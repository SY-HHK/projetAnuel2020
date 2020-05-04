<?php
include('../../include/config.php');
include('../../shop/FindProvider.php');


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

if ($state == 1) {

    if (!isset($hourEnd) || empty($hourEnd)){
        header('Location: ../request.php?error=hourEnd');
        exit;
    }

    if (!isset($dateEnd) || empty($dateEnd) || $dateEnd < $dateStart){
        header('Location: ../request.php?error=dateEnd');
        exit;
    }

	$deliveryInfos = array(
		"date" => $dateStart,
		"hourStart" => $hourStart,
		"hourStop" => $hourEnd,
		"idService" => $service,
	);

	$getIdUserCity = $pdo->prepare("SELECT userIdCity FROM USER INNER JOIN BILL ON BILL.idUser = USER.idUser WHERE idBill = ?");
	$getIdUserCity->execute([$idBill]);
	$idUserCity = $getIdUserCity->fetch();
	$idUserCity = $idUserCity["userIdCity"];

	$request = new FindProvider($deliveryInfos, $pdo);

	if ($request->checkProvider("", $idUserCity) == 0) {
		header('location: ../request.php?error=noProviderAvailible');
		exit;
	}

	$availibleProviders = $request->checkProvider("", $idUserCity);

	$idProvider = $request->findInSameLocation($availibleProviders, $idUserCity, "cityName"); //find in the same city
	if ($idProvider == -1) $idProvider = $request->findInSameLocation($availibleProviders, $idUserCity, "cityDepartement"); //find in the same department
	if ($idProvider == -1) $idProvider = $request->findInSameLocation($availibleProviders, $idUserCity, "cityRegion"); //region

	$time = $request->getTimeOfDelivery("");
	if ($time == -1) {
		header('location: ../request.php?error=noEnoughtTime');
		exit;
	}

	$getBillInfos = $pdo->prepare("SELECT * FROM BILL WHERE idBill = ?");
	$getBillInfos->execute([$idBill]);
	$billInfos = $getBillInfos->fetch();

	$getServiceInfos = $pdo->prepare("SELECT * FROM SERVICE WHERE idService = 1");
	$getServiceInfos->execute();
	$serviceInfos = $getServiceInfos->fetch();

	$description = $description." => Pour cette demande, ".$time." heure(s) à ".$serviceInfos["servicePrice"]."€ jugé(s) nécessaire(s) par le service client pour son accomplissement.";

	$billPrice = round($time * $serviceInfos["servicePrice"], 2);

	$queryUpdate = $pdo->prepare('UPDATE DELIVERY, BILL SET
		DELIVERY.deliveryDateStart = :dateStart,
		DELIVERY.deliveryDateEnd = :dateEnd,
		DELIVERY.deliveryHourStart = :hourStart,
		DELIVERY.deliveryState = :newState,
		DELIVERY.idService = :service,
		DELIVERY.deliveryHourEnd = :hourEnd,
		DELIVERY.idProvider = :idProvider,
		BILL.billDescription = :description,
		BILL.billState = :newBillState,
		BILL.billPrice = :billPrice
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
	'description' => htmlspecialchars($description),
  'newBillState' => 3,
	'idProvider' => $idProvider,
	'billPrice' => $billPrice
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

		$updateBill = $pdo->prepare("UPDATE BILL SET billState = 4 WHERE idBill = ?");
		$updateBill->execute([$idBill]);


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
