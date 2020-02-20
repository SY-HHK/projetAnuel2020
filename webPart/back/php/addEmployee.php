<?php

include('../../include/config.php');
// Vérification des champs
//Prenom
    if(!isset($_POST['firstName']) || empty($_POST['firstName'])){
        header('Location: ../employee.php?error=prenom_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['firstName'])) {
        header('location: ../employee.php?error=prenom_format');
        exit;
    }

     //Nom
    if(!isset($_POST['lastName']) || empty($_POST['lastName'])){
        header('Location: ../employee.php?error=name_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['lastName'])) {
        header('location: ../employee.php?error=name_format');
        exit;
    }


    // format de l'email

    if (!filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)){
        header('Location: ../employee.php?error=email_format');
        exit;
    }

    //Email
    if(!isset($_POST['mail']) || empty($_POST['mail'])){
        header('Location: ../employee.php?error=email_missing');
        exit;
    }


     //EMAIL DEJA utilisé ?
        $q = "SELECT employeeEmail FROM EMPLOYEE WHERE employeeEmail = ?";
        // var_dump($q);
        $req= $pdo->prepare($q);
        $req-> execute(array(
          $_POST['mail']
          
        ));

        $answers = [];
        while ($INDIVIDU = $req->fetch()) {
          $answers[] = $INDIVIDU;
        }
        if (count($answers) != 0) { //email deja pris
          header('Location: ../employee.php?error=email_taken');
          exit;
        }

// Insertion en BDD

        $firstName = htmlspecialchars($_POST['firstName']);
        $lastName = htmlspecialchars($_POST['lastName']);
        $email = htmlspecialchars($_POST['mail']);
        $newPwd = hash('sha256', uniqid());



$req = $pdo->prepare('INSERT INTO EMPLOYEE (employeeFirstName, employeeLastName, employeeEmail, employeePassword) VALUES ( :prenom, :nom, :mail, :pwd) ');



$req->execute(array(
  
  
  'prenom' => $firstName,
  'nom' => $lastName,
  'mail' => $email,
  'pwd' => $newPwd
  
));

header('Location: ../employee.php?add=ok');
  exit;


?>