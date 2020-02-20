<?php

include('../include/config.php');

if (!isset($_POST['mail']) || empty($_POST['mail'])) {
	header('location: ../connexion.php?error=connect_email_missing');
	exit;
}

if (!isset($_POST['password']) || empty($_POST['password'])) {
	header('location: ../connexion.php?error=connect_password_missing');
	exit;
}


$email = htmlspecialchars($_POST['mail']);
$password = hash('sha256', $_POST['password']);
// var_dump([$email, $password]);
// 
// Connexion admin 
$queryAdmin = $pdo->prepare('SELECT * FROM ADMIN WHERE pseudo = ? AND password = ?');
$queryAdmin->execute([$email, $password]);
$admin = $queryAdmin->fetch();


$err = 0;

if ($admin != 0) {
	session_start();
	$_SESSION['admin'] = $admin;
	header('location: ../back/indexBack.php?connexion_back=ok');
 exit;
} 


// Connexion USER
$queryUser = $pdo->prepare('SELECT * FROM USER WHERE (userEmail = ? AND userPassword = ?)');
$queryUser->execute(array(
	$email,
	$password
));
$user = $queryUser->fetch();
if ($user != 0) {
	session_start();
	$_SESSION['user'] = $user;
	header('location: ../profilUser.php?error=login_successfull');
	exit;
}

// Connexion PROVIDER
$queryUser = $pdo->prepare('SELECT * FROM PROVIDER WHERE (providerEmail = ? AND providerPassword = ?)');
$queryUser->execute([$email, $password]);
$user = $queryUser->fetch();
if ($user != 0) {
	session_start();
	$_SESSION['user'] = $user;
	header('location: ../profilProvider.php?error=login_successfull');
	exit;
}



//  header('location: ../connexion.php?error=no_account');
 exit;



?>