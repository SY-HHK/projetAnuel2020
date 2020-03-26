<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Page d'inscription particulier</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="css/inscription.css">
</head>

<body>

 <?php include('../include/config.php');

 include('../include/new_header.php');

 ?>

<div class="container" style="margin-bottom: 5%;">
  <!-- <div class="col-lg-4"></div> -->
  <!-- <div class="col-lg-4"> -->
      <!-- <div class="jumbotron"> -->
        <center> <h2> Inscription </h2> </center>

            <form action="../PHP/verificationInscription.php" method="post">

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
  <?php include('../include/new_footer.php'); ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script type="text/javascript">

<?php if (isset($_GET['error']) && $_GET['error'] == 'email_missing') { ?>
  M.toast({html: 'Vous devez indiquer votre adresse mail'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'name_missing') { ?>
  M.toast({html: 'Vous devez indiquez votre nom'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'name_format') { ?>
  M.toast({html: 'Veuillez revoir votre nom'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'prenom_missing') { ?>
  M.toast({html: 'Vous devez indiquer votre prenom'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'prenom_format') { ?>
  M.toast({html: 'Veuillez revoir votre prenom'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'email_missing') { ?>
  M.toast({html: 'Vous devez indiquez votre adresse mail'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'email_format') { ?>
  M.toast({html: 'Veuillez revoir votre adresse mail'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'email_taken') { ?>
  M.toast({html: 'Vous avez deja un compte'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'birth_missing') { ?>
  M.toast({html: 'Vous devez entrer votre date de naissance'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'phone_missing') { ?>
  M.toast({html: 'Vous devez entrer votre numéro de téléphone'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'phone_format') { ?>
  M.toast({html: 'Vous devez entrer un numéro de téléphone valide'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'adresse_missing') { ?>
  M.toast({html: 'Vous devez entrer votre adresse'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'departement_missing') { ?>
  M.toast({html: 'Vous devez entrer votre département'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'departement_format') { ?>
  M.toast({html: 'Vous devez entrer un département valide'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'city_missing') { ?>
  M.toast({html: 'Vous devez indiquer votre ville'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'city_format') { ?>
  M.toast({html: 'Veuillez revoir votre ville'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'region_missing') { ?>
  M.toast({html: 'Vous devez indiquer votre région'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'region_format') { ?>
  M.toast({html: 'Veuillez revoir votre région'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'password_missing') { ?>
  M.toast({html: 'Vous devez entrez un mot de passe'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'password_format') { ?>
  M.toast({html: 'Votre mot de passe doit contenir au moins une lettre miniscule, une lettre majuscule et 1 chiffre'});
<?php } ?>

  </script>

</body>
</html>
