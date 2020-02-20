<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Page d'inscription particulier</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/inscription.css">
</head>

<body>

 <?php include('include/config.php'); 

 include('css/linkCss.php');


 include('include/header.php'); 

 ?>
    
<div class="container">
  <!-- <div class="col-lg-4"></div> -->
  <!-- <div class="col-lg-4"> -->
      <!-- <div class="jumbotron"> -->
        <center> <h1> Inscription </h1> </center>
  
        <?php if (isset($_GET['error']) && $_GET['error'] == 'email_missing') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Vous devez indiquer votre adresse mail
          </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'name_missing') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Vous devez indiquez votre nom
          </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'name_format') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Veuillez revoir votre nom
          </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'prenom_missing') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Vous devez indiquer votre prenom
          </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'prenom_format') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Veuillez revoir votre prenom
          </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'email_missing') { ?>
          <div class="alert alert-danger text-center" role="alert">
             Vous devez indiquez votre adresse mail
          </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'email_format') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Veuillez revoir votre adresse mail
          </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'email_taken') { ?>
          <div class="alert alert-danger text-center" role="alert">
         Vous avez deja un compte
          </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'birth_missing') { ?>
        <div class="alert alert-danger text-center" role="alert">
         Vous devez entrer votre date de naissance
        </div>
<?php } else if (isset($_GET['error']) && $_GET['error'] == 'phone_missing') { ?>
        <div class="alert alert-danger text-center" role="alert">
         Vous devez entrer votre numéro de téléphone
        </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'phone_format') { ?>
<div class="alert alert-danger text-center" role="alert">
 Vous devez entrer un numéro de téléphone valide
</div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'adresse_missing') { ?>
        <div class="alert alert-danger text-center" role="alert">
         Vous devez entrer votre adresse
        </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'departement_missing') { ?>
        <div class="alert alert-danger text-center" role="alert">
         Vous devez entrer votre département
        </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'departement_format') { ?>
<div class="alert alert-danger text-center" role="alert">
 Vous devez entrer un département valide
</div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'city_missing') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Vous devez indiquer votre ville
          </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'city_format') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Veuillez revoir votre ville
          </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'region_missing') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Vous devez indiquer votre région
          </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'region_format') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Veuillez revoir votre région
          </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'password_missing') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Vous devez entrez un mot de passe
          </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'password_format') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Votre mot de passe doit contenir au moins une lettre miniscule, une lettre majuscule et 1 chiffre
          </div>

<?php } ?>      
            <form action="PHP/verificationInscription.php" method="post">

              <div class="form-group">
                <label>Adresse email :</label>
                <input type="email" class="form-control" name="mail" aria-describedby="emailHelp" placeholder="Email">
            </div>

            <div class="form-group">
                <label>Prénom :</label>
                <input type="text" class="form-control" name="firstName" placeholder="Prénom">
            </div>
            <div class="form-group">
                <label>Nom de famille :</label>
                <input type="text" class="form-control" name="lastName" placeholder="Nom de famille">
            </div>
            <div class="form-group">
                <label>Date de naissance :</label>
                <input type="date" class="form-control" name="birth" placeholder="Date de naissance">
            </div>
            <div class="form-group">
                <label>Numéro de téléphone:</label>
                <input type="text" class="form-control" name="phone" placeholder="Numéro de téléphone">
            </div>
            <div class="form-group">
                <label>Adresse :</label>
                <input type="text" class="form-control" name="adresse" placeholder="Adresse">
            </div>
            <div class="form-group">
                <label>Ville :</label>
                <input type="text" class="form-control" name="city" placeholder="Ville">
            </div>
            <div class="form-group">
                <label>Région : </label>
                <input type="text" class="form-control" name="region" placeholder="Région">
            </div>
            <div class="form-group">
                <label>Département : </label>
                <input type="text" class="form-control" name="departement" placeholder="Département">
            </div>
            
            <div class="form-group">
                <label>Mot de passe :</label>
                <input type="password" class="form-control" name="password" placeholder="Mot de passe">
            </div>
            <div class="form-group">
                <br>
                <input type="Submit" class="btn btn-primary" name="Submit">
            </div>

          </form>
           
  </div>




<div class="col-lg-4"></div>
</div>
  <!-- <?php include('include/footer.php'); ?> -->
</body>
</html>