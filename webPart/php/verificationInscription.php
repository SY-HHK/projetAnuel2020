<?php
include('../include/config.php');
    // VERIFICATION DES CHAMPS

    // format de l'email

    if (!filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)){
        header('Location: ../inscription.php?error=email_format');
        exit;
    }

    //Email
    if(!isset($_POST['mail']) || empty($_POST['mail'])){
        header('Location: ../inscription.php?error=email_missing');
        exit;
    }


    //EMAIL DEJA utilisé ?
        $q = "SELECT userEmail FROM USER WHERE userEmail = ?";
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
          header('Location: ../inscription.php?error=email_taken');
          exit;
        }

     //Nom
    if(!isset($_POST['lastname']) || empty($_POST['lastname'])){
        header('Location: ../inscription.php?error=name_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['lastname'])) {
        header('location: ../inscription.php?error=name_format');
        exit;
    }
    //Prenom
    if(!isset($_POST['firstname']) || empty($_POST['firstname'])){
        header('Location: ../inscription.php?error=prenom_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['firstname'])) {
        header('location: ../inscription.php?error=prenom_format');
        exit;
    }

    

    // Date de naissance
    if(!isset($_POST['birth']) || empty($_POST['birth'])){
        header('Location: ../inscription.php?error=birth_missing');
        exit;
    }

    if(!isset($_POST['phone']) || empty($_POST['phone'])){
        header('Location: ../inscription.php?error=phone_missing');
        exit;
    }

    if(preg_match('#[a-zA-Z]#',$_POST['phone'])) {
        header('location: ../inscription.php?error=phone_format');
        exit;
    }
    
    //Adresse
    if(!isset($_POST['adresse']) || empty($_POST['adresse'])){
        header('Location: ../inscription.php?error=adresse_missing');
        exit;
    }


    // code postal
    if(!isset($_POST['postalCode']) || empty($_POST['postalCode'])){
        header('Location: ../inscription.php?error=postalCode_missing');
        exit;
    }

    if(preg_match('#[a-zA-Z]#',$_POST['postalCode'])) {
        header('location: ../inscription.php?error=postalCode_format');
        exit;
    }


 //Ville
    if(!isset($_POST['city']) || empty($_POST['city'])){
        header('Location: ../inscription.php?error=city_missing');
        exit;
    }

    if(preg_match('#[0-9]#',$_POST['city'])) {
        header('location: ../inscription.php?error=city_format');
        exit;
    }

// mdp

    if(!isset($_POST['password']) || empty($_POST['password'])){
            header('location: ../inscription.php?error=password_missing');
            exit;
        }
    ?>
  <script>
        const pwdInput = document.getElementByName('password');
        if(checkPassword(pwdInput.value) == false ) {
          header('location: ../inscription.php?error=password_format');
         }

        function checkPassword(p) {
        if(countLowerCase(p) > 0 &&
           countUpperCase(p) > 0 &&
           countNumbers(p) > 0) {
          return true;
        }
          return false;
        }

        function countAscii(str, from, to) {
          let count = 0;
          for(let i = 0; i < str.length; i++) {
            const ascii = str.charCodeAt(i);
            if(ascii >= from && ascii <= to) {
              count += 1;
            }
          }
          return count;
        }

        function countLowerCase(str) {
          return countAscii(str, 97, 122);
        }

        function countUpperCase(str) {
          return countAscii(str, 65, 90);
        }

        function countNumbers(str) {
          return countAscii(str, 48, 57);
        }
  </script>

  <?php

// Insertion bdd

// Requete preparee

$q = "INSERT INTO USER (userEmail, userPassword, userFirstName, userLastName , userBirth, userAddress,userCity, userPostalCode, userPhone,userPrivilege, userIp, userAgent) VALUES ( :mail, :pwd, :firstName, :lastName , :birth, :adr,:city, :code,:phone, :p, :id, :agent)";

$req = $pdo->prepare($q);

$privilege = 1;

$userIp = $_SERVER['REMOTE_ADDR'];
$userAgent =  $_SERVER['HTTP_USER_AGENT'];


var_dump($userAgent);
var_dump($userIp);
$req->execute(array(
  'mail' => htmlspecialchars($_POST['mail']),
  'pwd' => hash('sha256', $_POST['password']),
  'firstName' => htmlspecialchars($_POST['firstname']),
  'lastName' => htmlspecialchars($_POST['lastname']),
  'birth' => htmlspecialchars($_POST['birth']),
  'adr' => htmlspecialchars($_POST['adresse']),
  'city' => htmlspecialchars($_POST['city']),
  'code' => htmlspecialchars($_POST['postalCode']),
  'phone' => htmlspecialchars($_POST['phone']),
  'p' => $privilege,
  'id' => $userIp,
  'agent' => $userAgent
));

header('Location: ../connexion.php?inscription=ok');
  exit;

?>