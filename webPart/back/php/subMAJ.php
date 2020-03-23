<?php
include('../../include/config.php');


// Vérification des champs
  //Nom
    if(!isset($_POST['name']) || empty($_POST['name'])){
        header('Location: ../subscription.php?error=name_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['name'])) {
        header('location: ../subscription.php?error=name_format');
        exit;
    }

    //Hour
    if(!isset($_POST['hour']) || empty($_POST['hour'])){
        header('Location: ../subscription.php?error=hour_missing');
        exit;
    }

     if(preg_match('#[a-zA-z]#',$_POST['hour'])) {
        header('location: ../subscription.php?error=hour_format');
        exit;
    }

     if($_POST['hour'] > 730 || $_POST['hour'] < 1) {
        header('location: ../subscription.php?error=hour_format');
        exit;
    }

    //Price
    if(!isset($_POST['price']) || empty($_POST['price'])){
        header('Location: ../subscription.php?error=price_missing');
        exit;
    }

    if(preg_match('#[a-zA-z]#',$_POST['price'])) {
        header('location: ../subscription.php?error=price_format');
        exit;
    }

     if($_POST['price'] < 10) {
        header('location: ../subscription.php?error=price_format');
        exit;
    }

$name = htmlspecialchars($_POST['name']);
$days = htmlspecialchars($_POST['days']);
$start = htmlspecialchars($_POST['start']);
$ending = htmlspecialchars($_POST['end']);
$hour = htmlspecialchars($_POST['hour']);
$price = htmlspecialchars($_POST['price']);


// MAJ abonnement
if (isset($_POST['updateSub'])){
// Insertion en BDD

    // Création des variables

$id = $_POST['idSub'];


$queryUpdate = $pdo->prepare('UPDATE SUBSCRIPTION SET
	subName = :name,
	subDays = :days,
	subHourStart = :start,
	subHourEnd = :ending,
	subHour = :hour,
	subPrice = :price WHERE idSub = :id');


$queryUpdate->execute(array(
'id' => $id,
'name' => $name,
'days' => $days,
'start' => $start,
'ending' => $ending,
'hour' => $hour,
'price' => $price

));

$rows = $queryUpdate->rowCount();

   if ($rows == 1){
    header('location: ../subscription.php?update='.$rows);
        exit;
  } else {
    header('location: ../subscription.php');
        exit;
  }
}

// Ajouter un abonnement
if (isset($_POST['addSub'])){

$req = $pdo->prepare('INSERT INTO SUBSCRIPTION (subName, subDays, subHourStart, subHourEnd, subHour, subPrice) VALUES ( :name, :days, :start, :ending, :hour, :price) ');



$req->execute(array(
  'name' => $name,
  'days' => $days,
  'start' => $start,
  'ending' => $ending,
  'hour' => $hour,
  'price' => $price
  
));

header('Location: ../subscription.php?add=ok');
  exit;

}


if (isset($_POST['delete'])) {
	include('../../include/config.php');

	$id = $_POST['idSub'];

	$queryDelete = $pdo->prepare('DELETE FROM 		SUBSCRIPTION WHERE idSub = ?');
	$queryDelete->execute(array($id));

	$rows2 = $queryDelete->rowCount();

	 if ($rows2 == 1){
		header('location: ../subscription.php?delete='.$rows2.'&id='.$id );
        exit;
	} 
}

?>