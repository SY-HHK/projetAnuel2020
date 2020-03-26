<?php
include('../../include/config.php');


// Vérification des champs
  //Nom
    if(!isset($_POST['name']) || empty($_POST['name'])){
        header('location: ../service.php?error=name_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['name'])) {
        header('location: ../service.php?error=name_format');
        exit;
    }

    //Price
    if(!isset($_POST['price']) || empty($_POST['price'])){
        header('Location: ../service.php?error=price_missing');
        exit;
    }

     if(preg_match('#[a-zA-z]#',$_POST['price'])) {
        header('location: ../service.php?error=price_format');
        exit;
    }

     if($_POST['price'] < 5) {
        header('location: ../service.php?error=price_format');
        exit;
    }

  //Description
    if(!isset($_POST['description']) || empty($_POST['description'])){
        header('location: ../service.php?error=description_missing');
        exit;
    }




// MAJ service
if (isset($_POST['updateSub'])){
// Insertion en BDD

    // Création des variables

$id = $_POST['idService'];
$name = htmlspecialchars($_POST['name']);
$price = htmlspecialchars($_POST['price']);
$description = htmlspecialchars($_POST['description']);

echo $id;
$queryUpdate = $pdo->prepare('UPDATE SERVICE SET
	serviceTitle = :name,
	servicePrice = :price,
  serviceDescription = :description WHERE idService = :id');


$queryUpdate->execute(array(
'id' => $id,
'name' => $name,
'price' => $price,
'description' => $description

));

$rows = $queryUpdate->rowCount();

   if ($rows == 1){
    header('location: ../service.php?update='.$rows);
        exit;
  } else {
    header('location: ../service.php');
        exit;
  }
}

// // Ajouter un service
if (isset($_POST['addService'])){

$name = htmlspecialchars($_POST['name']);
$price = htmlspecialchars($_POST['price']);
$description = htmlspecialchars($_POST['description']);

$req = $pdo->prepare('INSERT INTO service (serviceTitle, servicePrice, serviceDescription, serviceValidate) VALUES (:title, :price, :description, :validation)');

$req->execute(array(
  'title' => $name,
  'price' => $price,
  'description' => $description,
  'validation' =>1
));

header('Location: ../service.php?add=ok');
  exit;

}


if (isset($_POST['delete'])) {
	include('../../include/config.php');

	$id = $_POST['idService'];

	$queryDelete = $pdo->prepare('DELETE FROM service WHERE idService = ?');
	$queryDelete->execute(array($id));

	$rows2 = $queryDelete->rowCount();

	 if ($rows2 == 1){
		header('location: ../service.php?delete='.$rows2.'&id='.$id );
        exit;
	}
}

?>
