<?php
include('../../include/config.php');


if (isset($_POST['pwd'])) {
include('../../include/config.php');
	$id = $_POST['idEmployee'];
	$newPwd = hash('sha256', uniqid());
var_dump($newPwd);

	$queryUpdate = $pdo->prepare('UPDATE USER SET userPassword = :pwd WHERE idUser = :id');

	$queryUpdate->execute(array(
		'id' => $id,
		'pwd' => $newPwd
		));

	$rows = $queryUpdate->rowCount();

	 if ($rows == 1){
		header('location: ../employee.php?genere='.$rows);
        exit;
	} else {
		header('location: ../employee.php');
        exit;
	}

}



if (isset($_POST['delete'])) {
	include('../../include/config.php');

	$id = $_POST['idEmployee'];

	$queryDelete = $pdo->prepare('DELETE FROM USER WHERE idUser = ?');
	$queryDelete->execute(array($id));

	$rows2 = $queryDelete->rowCount();

	 if ($rows2 == 1){
		header('location: ../employee.php?delete='.$rows2.'&id='.$id );
        exit;
	}
}
?>
