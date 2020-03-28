<?php
include('../../include/config.php');


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


// Vérification des champs
  // Nom
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

    // Image

    $service = $_POST['idService'];

    $photo_name = 'service'. $service;

    echo $photo_name;
    $filename = $_FILES['image']['name']; // récupère le nom de base du fichier avec son extension
    $temp_array = explode('.', $filename); // 'explode' = transf chaine de char en tab
    $imageFileType = strtolower(end($temp_array)); // Transforme la chaine de char en miniscule prend le dernier élement du tableau (ici l'exension)
    $photo_path = '../images/' . $photo_name . ".". $imageFileType;


  // Verification type de fichier

    if ($imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "jpg"){
      header("location: ../service.php?error=file_type");
      exit;
    } 

    // vérification taille du fichier
    $maximumsize = 4097152; // 2Mo: 2*1024*1024
    if(($_FILES['image']['size'] >= $maximumsize)){  // si le fichier dépasse la taille max -> redirection
      header("location: ../service.php?error=file_size");
      exit;
    }


    move_uploaded_file($_FILES['image']['tmp_name'], '../'.$photo_path);




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
  serviceDescription = :description,
  serviceImage = :image WHERE idService = :id');


$queryUpdate->execute(array(
'id' => $id,
'name' => $name,
'price' => $price,
'description' => $description,
'image' => $photo_path

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

$req = $pdo->prepare('INSERT INTO service (serviceTitle, servicePrice, serviceDescription, serviceImage, serviceValidate) VALUES (:title, :price, :description, :image, :validation)');

$req->execute(array(
  'title' => $name,
  'price' => $price,
  'description' => $description,
  'image' => $photo_path,
  'validation' =>1
));

header('Location: ../service.php?add=ok');
  exit;

}




?>
