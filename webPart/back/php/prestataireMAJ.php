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




	$queryUpdate = $pdo->prepare('UPDATE PROVIDER, CITY SET
		PROVIDER.providerFirstName = :fn,
		PROVIDER.providerLastName = :ln,
		PROVIDER.providerPhone = :t,
		PROVIDER.providerEmail = :mail,
		PROVIDER.providerAddress = :a,
		CITY.cityName = :city,
		CITY.cityRegion = :region,
		CITY.cityDepartement = :departement,
		PROVIDER.companyName = :companyName,
		PROVIDER.providerAnnulation = :annulation,
		PROVIDER.state = :state

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



// // Ajouter un contract
if (isset($_POST['addContract'])){

  $idService = $_POST['idService'];
  $start = htmlspecialchars($_POST['startContract']);
  $end = htmlspecialchars($_POST['endContract']);
  $price = htmlspecialchars($_POST['priceContract']);
  $provider = $_POST['idProvider'];


   // Date de debut
    if(!isset($start) || empty($start)){
        header('Location: ../provider.php?error=start_missing');
        exit;
    }

     // Date de fin
    if(!isset($end) || empty($end)){
        header('Location: ../provider.php?error=end_missing');
        exit;
    }

    // dates cohérences

    if($start > $end){
      header('Location: ../provider.php?error=date_format');
        exit;
    }

    // Prix
    if(!isset($price) || empty($price)){
        header('Location: ../provider.php?error=priceContract_missing');
        exit;
    }

    if(preg_match('#[a-zA-z]#',$price)) {
        header('location: ../provider.php?error=priceContract_format');
        exit;
    }

     if($price < 1) {
        header('location: ../provider.php?error=priceContract_format');
        exit;
    }

$req = $pdo->prepare('INSERT INTO CONTRACT (contractDateStart, contractDateEnd, contractPrice, idService, idProvider) VALUES (:start, :fin, :price, :service, :provider)');

$req->execute(array(
  'start' => $start,
  'fin' => $end,
  'price' => $price,
  'service' => $idService,
  'provider' => $provider
));

header('Location: ../provider.php?addContract=1');
  exit;

}

// Renouveler un contract de 18 mois

if (isset($_GET['idContract']) && !empty($_GET['idContract']) && isset($_GET['start']) && !empty($_GET['start']) && isset($_GET['end']) && !empty($_GET['end'])) {

  $idContract = htmlspecialchars($_GET['idContract']);
  $start = $_GET['start'];
  $end = $_GET['end'];

  $date = date_create($end);

  date_add($date, date_interval_create_from_date_string('18 months'));

  $start = $end;
  $end = $date;

  $end =  date_format($date, 'Y-m-d');

  $queryUpdate = $pdo->prepare('UPDATE CONTRACT SET contractDateStart = :start, contractDateEnd = :endContract WHERE idContract = :id');

  $queryUpdate->execute(array(
    'id' => $idContract,
    'start' => $start,
    'endContract' => $end
    ));

  $rows = $queryUpdate->rowCount();

   if ($rows == 1){
    header('location: ../provider.php?renew='.$rows);
        exit;
  } else {
    header('location: ../provider.php');
        exit;
  }

}


// Supprimer un contract

if (isset($_GET['deleteContract']) && !empty($_GET['deleteContract'])) {
  include('../../include/config.php');

  $id = $_GET['deleteContract'];

  $queryDelete = $pdo->prepare('DELETE FROM CONTRACT WHERE idContract = ?');
  $queryDelete->execute(array($id));

  $rows2 = $queryDelete->rowCount();

   if ($rows2 == 1){
    header('location: ../provider.php?deleteContract='.$rows2 );
        exit;
  }
}




?>
