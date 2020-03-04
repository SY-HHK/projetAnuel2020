<?php

include('../../include/config.php');
// Vérification des champs

if (isset($_POST['updateProvider'])) {

	//Prenom
    if(!isset($_POST['firstName']) || empty($_POST['firstName'])){
        header('Location: ../provider.php?error=prenom_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['firstName'])) {
        header('location: ../provider.php?error=prenom_format');
        exit;
    }

     //Nom
    if(!isset($_POST['lastName']) || empty($_POST['lastName'])){
        header('Location: ../provider.php?error=name_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['lastName'])) {
        header('location: ../provider.php?error=name_format');
        exit;
    }

    // Tel
    if(!isset($_POST['phone']) || empty($_POST['phone'])){
        header('Location: ../provider.php?error=phone_missing');
        exit;
    }

    if(preg_match('#[a-zA-Z]#',$_POST['phone'])) {
        header('location: ../provider.php?error=phone_format');
        exit;
    }

    // format de l'email

    if (!filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)){
        header('Location: ../provider.php?error=email_format');
        exit;
    }

    //Email
    if(!isset($_POST['mail']) || empty($_POST['mail'])){
        header('Location: ../provider.php?error=email_missing');
        exit;
    }

    //Adresse
    if(!isset($_POST['adresse']) || empty($_POST['adresse'])){
        header('Location: ../provider.php?error=adresse_missing');
        exit;
    }


     //Ville
    if(!isset($_POST['city']) || empty($_POST['city'])){
        header('Location: ../provider.php?error=city_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['city'])) {
        header('location: ../provider.php?error=city_format');
        exit;
    }


	// region
	    if(!isset($_POST['region']) || empty($_POST['region'])){
	        header('Location: ../provider.php?error=region_missing');
	        exit;
	    }

	    if(preg_match('#[0-9]#',$_POST['region'])) {
	        header('location: ../provider.php?error=region_format');
	        exit;
	    }

	 // departement
	    if(!isset($_POST['departement']) || empty($_POST['departement'])){
	        header('Location: ../provider.php?error=region_missing');
	        exit;
	    }

	    if(preg_match('#[a-zA-Z]#',$_POST['departement'])) {
	        header('location: ../provider.php?error=departement_format');
	        exit;
	    }



	// Insertion en BDD
	    $id = $_POST['idProvider'];
	    $firstName = htmlspecialchars($_POST['firstName']);
	    $lastName = htmlspecialchars($_POST['lastName']);
	    $tel = htmlspecialchars($_POST['phone']);
	    $email = htmlspecialchars($_POST['mail']);
	    $adr = htmlspecialchars($_POST['adresse']);
	    $city = htmlspecialchars($_POST['city']);
	    $region = htmlspecialchars($_POST['region']);
	    $departement = htmlspecialchars($_POST['departement']);

	   if( isset($_POST['companyName']) && !empty($_POST['companyName']) ){
	        $companyName = $_POST['companyName'];
	    }else {
	    	$companyName = ".";
	    }

	    if( isset($_POST['annulation']) && !empty($_POST['annulation']) ){
	        $annulation = $_POST['annulation'];
	    }else {
	    	$annulation = 0;
	    }


	   	$state = $_POST['state'];

	   if ($state == 'A') {
	   	$state = 0; // activé
	   } else if ($state == 'V'){
	   	$state = 1; //en veille
	   }else if ($state == "S"){
	   	$state = 2; //supprimé
	   }




	$queryUpdate = $pdo->prepare('UPDATE PROVIDER SET
		providerFirstName = :fn,
		providerLastName = :ln,
		providerPhone = :t,
		providerEmail = :mail,
		providerAddress = :a,
		cityName = :city,
		cityRegion = :region,
		cityDepartement = :departement,
		companyName = :companyName,
		providerAnnulation = :annulation,
		state = :state

		WHERE idProvider = :id');

	$queryUpdate->execute(array(
		'id' => $id,
		'fn' => $firstName,
		'ln' => $lastName,
		't' => $tel,
		'mail'=> $email,
		'a' => $adr,
		'city' => $city,
		'region' => $region,
		'departement' => $departement,
		'companyName' => $companyName,
		'annulation' => $annulation,
		'state' => $state
		));

	$rows = $queryUpdate->rowCount();

	 if ($rows == 1){
		header('location: ../provider.php?update='.$rows);
        exit;
	} else {
		header('location: ../provider.php');
        exit;
	}


}

// Générer un mdp

if (isset($_POST['pwd'])) {

	$id = $_POST['idProvider'];
	$newPwd = hash('sha256', uniqid());
var_dump($newPwd);

	$queryUpdate = $pdo->prepare('UPDATE PROVIDER SET providerPassword = :pwd WHERE idProvider = :id');

	$queryUpdate->execute(array(
		'id' => $id,
		'pwd' => $newPwd
		));

	$rows = $queryUpdate->rowCount();

	 if ($rows == 1){
		header('location: ../provider.php?genere='.$rows);
        exit;
	} else {
		header('location: ../provider.php');
        exit;
	}

}


?>
