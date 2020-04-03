<?php
include('../../include/config.php');



if (isset($_POST['enregistrer'])){


	$state = $_POST['state'];
	$title = $_POST['name'];
	$description = $_POST['description'];
	$idRequest = $_POST['idRequest'];

	
if ($state == 1){

	$queryUpdate = $pdo->prepare('UPDATE SERVICE SET
		serviceValidate = :newState,
		servicePrice = :price,
		serviceImage = :image
		WHERE idService = :id');


	$queryUpdate->execute(array(
	'id' => $idRequest,
	'newState' => 2,
	'price' => 50,
	'image' => htmlspecialchars('../images/request.png')

	));

	$rows = $queryUpdate->rowCount();

   	if ($rows == 1){
   		header('location: ../service.php?request='.$rows);
        exit;
  	} else {
    	header('location: ../service.php');
        exit;
  	}
  } else {


  	$queryUpdate = $pdo->prepare('UPDATE SERVICE SET
		serviceValidate = :newState
		WHERE idService = :id');


	$queryUpdate->execute(array(
	'id' => $idRequest,
	'newState' => 2
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