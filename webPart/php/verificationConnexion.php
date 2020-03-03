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
// Connexion admin / user
$queryUser = $pdo->prepare('SELECT * FROM USER WHERE userEmail = ? AND userPassword = ?');
$queryUser->execute([$email, $password]);
$nb = $queryUser->rowCount();
$res = $queryUser->fetch();

if ($nb == 1) {

	if ($res["userPrivilege"] == 10) {
		session_start();
		$_SESSION['admin'] = $res;
		header('location: ../back/indexBack.php?connexion_back=ok');
	 exit;
	}
	else {
		session_start();
		$_SESSION['user'] = $res;
		header('location: ../profilUser.php?error=login_successfull');
		exit;
	}
}
else {

	// Connexion PROVIDER
	$queryProvider = $pdo->prepare('SELECT * FROM PROVIDER WHERE providerEmail = ? AND providerPassword = ?');
	$queryProvider->execute([$email, $password]);
	$nb = $queryProvider->rowCount();
	$res = $queryProvider->fetch();
	if ($nb == 1) {
		session_start();
		$_SESSION['user'] = $res;
		header('location: ../profilProvider.php?error=login_successfull');
		exit;
	}
	else {
		header('location: ../connexion.php?error=no_user');
		exit;
	}
}

?>
