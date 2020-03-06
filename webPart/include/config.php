<?php
/*
$serveur = 'localhost';
$login = '';
$mot_de_passe = '';
$base_de_donnees = 'PA2020';
$charset = 'UTF8';
$port = 8889;

$pdo = new PDO('mysql:host=' . $serveur . ';dbname=' . $base_de_donnees . ';charset=' . $charset, $login, $mot_de_passe);



*/

// $pdo = new PDO('mysql:host=localhost:3306;dbname= bringme ','my_user','my_password');
?>

<?php
  try
  {
    $pdo = new PDO('mysql:host=localhost:3306;dbname=bringme', 'admin', 'test123', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
  catch(Exception $e)
  {
    die('Erreur : ' . $e->getMessage());
  }
?>
