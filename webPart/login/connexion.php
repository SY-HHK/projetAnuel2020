<?php
include('../include/lang.php');
include('../include/config.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lang['logIn']; ?></title>
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
   <center> <h2> <?php echo $lang['logIn']; ?> </h2> </center>

    <form action="../php/verificationConnexion.php" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $lang['email']; ?></label>
            <input type="email" class="form-control" name="mail" aria-describedby="emailHelp" placeholder="<?php echo $lang['email']; ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1"><?php echo $lang['pwd']; ?></label>
            <input type="password" name = "password" class="form-control" placeholder="<?php echo $lang['pwd']; ?>">
        </div>
        <input type="submit" class="btn btn-success form control" value="<?php echo $lang['logIn']; ?>">
    </form>
    <br>
    <small><a href="inscription.php"><?php echo $lang['linkSignUp']; ?></a></small>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript">

<?php
 if (isset($_GET['inscription']) && $_GET['inscription'] == 'ok') { ?>
   M.toast({html: '<?php echo $lang['inscription=ok']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'connect_email_missing') { ?>
    M.toast({html: '<?php echo $lang['error=connect_email_missing']; ?>' });

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'connect_password_missing') { ?>
    M.toast({html: '<?php echo $lang['error=connect_password_missing']; ?>'});

<?php } else if (isset($_GET['error']) &&  $_GET['error'] == 'no_user') { ?>
    M.toast({html: '<?php echo $lang['error=no_user']; ?>'});

<?php } else if (isset($_GET['error']) &&  $_GET['error'] == 'plz_login') { ?>
    M.toast({html: '<?php echo $lang['error=plz_login']; ?>'});

<?php }?>

</script>

</body>
 <?php include('../include/new_footer.php'); ?>
</html>
