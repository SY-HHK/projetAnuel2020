<?php

include('../include/config.php');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>

<?php

include ('../include/new_header.php');

?>

<br>

<div class="container">
   <center> <h2> Connexion </h2> </center>

    <form action="../php/verificationConnexion.php" method="post">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript">

<?php
 if (isset($_GET['inscription']) && $_GET['inscription'] == 'ok') { ?>
   M.toast({html: 'Votre compte a bien été crée, vous pouvez maintenant vous connecter'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'connect_email_missing') { ?>
    M.toast({html: 'L\'email doit etre rempli'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'connect_password_missing') { ?>
    M.toast({html: 'Le mdp doit etre rempli'});

<?php } else if (isset($_GET['error']) &&  $_GET['error'] == 'no_user') { ?>
    M.toast({html: 'Mauvais email/mot de passe'});

<?php } else if (isset($_GET['error']) &&  $_GET['error'] == 'plz_login') { ?>
    M.toast({html: 'Veuillez vous connecter pour accéder à cette page'});

<?php }?>

</script>

</body>
</html>
