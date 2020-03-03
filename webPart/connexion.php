<?php

include('include/config.php');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <meta charset="UTF-8">
    <?php include('css/linkCss.php');?>
    <link rel="stylesheet" href="css/connexion.css">

</head>

<body>

<?php

include ('include/header.php');

?>

<br>

<div class="container">
   <center> <h1> Connexion </h1> </center>

<?php
 if (isset($_GET['inscription']) && $_GET['inscription'] == 'ok') { ?>
    <div class="alert alert-success text-center" role="alert">
            <h2>Votre compte a bien été crée, vous pouvez maintenant vous connecter</h2>
    </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'connect_email_missing') { ?>
        <div class="alert alert-danger text-center" role="alert">
          <h2>L'email doit etre rempli</h2>
        </div>

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'connect_password_missing') { ?>
        <div class="alert alert-danger text-center" role="alert">
          <h2>Le mdp doit etre rempli</h2>
        </div>

<?php } else if (isset($_GET['error']) &&  $_GET['error'] == 'no_account') { ?>
      <div class="alert alert-danger text-center" role="alert">
        <h2> Mauvais email/mot de passe</h2>
      </div>
<?php }?>

    <form action="php/verificationConnexion.php" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Adresse mail</label>
            <input type="email" class="form-control" name="mail" aria-describedby="emailHelp" placeholder="adresse mail">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Mot de passe</label>
            <input type="password" name = "password" class="form-control" placeholder="mot de passe">
        </div>
        <input type="submit" class="btn btn-success form control" Se connecter/>
    </form>
    <br>
    <small><a href="inscription.php">Si tu n'as pas de compte inscrit toi ici</a></small>

</div>

</body>
</html>
