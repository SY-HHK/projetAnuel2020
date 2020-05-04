<?php
include('../../include/config.php');
    // VERIFICATION DES CHAMPS
if (isset($_POST['updateUser'])) {

    // format de l'email

    if (!filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)){
        header('Location: ../user.php?error=email_format');
        exit;
    }

    //Email
    if(!isset($_POST['mail']) || empty($_POST['mail'])){
        header('Location: ../user.php?error=email_missing');
        exit;
    }

     //Nom
    if(!isset($_POST['lastName']) || empty($_POST['lastName'])){
        header('Location: ../user.php?error=name_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['lastName'])) {
        header('location: ../user.php?error=name_format');
        exit;
    }
    //Prenom
    if(!isset($_POST['firstName']) || empty($_POST['firstName'])){
        header('Location: ../user.php?error=prenom_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['firstName'])) {
        header('location: ../user.php?error=prenom_format');
        exit;
    }

    

    // Date de naissance
    if(!isset($_POST['birth']) || empty($_POST['birth'])){
        header('Location: ../user.php?error=birth_missing');
        exit;
    }

    if(!isset($_POST['phone']) || empty($_POST['phone'])){
        header('Location: ../user.php?error=phone_missing');
        exit;
    }

    if(preg_match('#[a-zA-Z]#',$_POST['phone'])) {
        header('location: ../user.php?error=phone_format');
        exit;
    }
    
    //Adresse
    if(!isset($_POST['adresse']) || empty($_POST['adresse'])){
        header('Location: ../user.php?error=adresse_missing');
        exit;
    }


    // region
    if(!isset($_POST['region']) || empty($_POST['region'])){
        header('Location: ../user.php?error=region_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['region'])) {
        header('location: ../user.php?error=region_format');
        exit;
    }

 // departement
    if(!isset($_POST['departement']) || empty($_POST['departement'])){
        header('Location: ../user.php?error=region_missing');
        exit;
    }

    if(preg_match('#[a-zA-Z]#',$_POST['departement'])) {
        header('location: ../user.php?error=departement_format');
        exit;
    }
 //Ville
    if(!isset($_POST['city']) || empty($_POST['city'])){
        header('Location: ../user.php?error=city_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['city'])) {
        header('location: ../user.php?error=city_format');
        exit;
    }

// Insertion bdd

// Requete preparee
  $id = $_POST['idUser'];
  $mail = htmlspecialchars($_POST['mail']);
  $firstName = htmlspecialchars($_POST['firstName']);
  $lastName = htmlspecialchars($_POST['lastName']);
  $phone = htmlspecialchars($_POST['phone']);
  $birth = htmlspecialchars($_POST['birth']);
  $adr = htmlspecialchars($_POST['adresse']);
  $city = htmlspecialchars($_POST['city']);
  $region = htmlspecialchars($_POST['region']);
  $departement =htmlspecialchars($_POST['departement']);
  $state =htmlspecialchars($_POST['state']);

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


  $queryUpdate = $pdo->prepare('UPDATE USER, CITY SET 
    USER.userEmail = :mail,
    USER.userFirstName = :firstName,
    USER.userLastName = :lastName,
    USER.userPhone = :phone,
    USER.userBirth = :birth,
    USER.userAddress = :adr,
    USER.userAnnulation = :annulation,
    CITY.cityName = :city,
    CITY.cityRegion = :region,
    CITY.cityDepartement = :departement,
    USER.state = :state

    WHERE idUser = :id');

$queryUpdate->execute(array(
  'id' => $id,
  'mail' => $mail,
  'firstName' => $firstName,
  'lastName' => $lastName,
  'phone' => $phone,
  'birth' => $birth,
  'adr' => $adr,
  'city' => $city,
  'region' => $region,
  'departement' => $departement,
  'annulation' => $annulation,
  'state' => $state
  

));

$rows = $queryUpdate->rowCount();

   if ($rows == 1){
    header('location: ../user.php?update='.$rows);
        exit;
  } else {
    header('location: ../user.php');
        exit;
  }

}

// Générer un mdp

if (isset($_POST['pwd'])) {

  $id = $_POST['idUser'];
  $newPwd = hash('sha256', uniqid());

  $queryUpdate = $pdo->prepare('UPDATE USER SET userPassword = :pwd WHERE idUser = :id');

  $queryUpdate->execute(array(
    'id' => $id,
    'pwd' => $newPwd
    ));

  $rows = $queryUpdate->rowCount();

   if ($rows == 1){
    header('location: ../user.php?genere='.$rows);
        exit;
  } else {
    header('location: ../user.php?error=pwd');
        exit;
  }

}



?>