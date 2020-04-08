<?php
include('../include/lang.php');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $lang['titleSignIn'];?></title>
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
        <center> <h2> <?php echo $lang['signIn'];?> </h2> </center>

            <form action="../PHP/verificationInscription.php" method="post">

              <div class="form-group">
                <label><?php echo $lang['email'];?> :</label>
                <input type="email" class="form-control" name="mail" aria-describedby="emailHelp" placeholder="<?php echo $lang['email'];?>">
            </div>

            <div class="form-group">
                <label><?php echo $lang['firstName'];?> :</label>
                <input type="text" class="form-control" name="firstName" placeholder="<?php echo $lang['firstName'];?>">
            </div>
            <div class="form-group">
                <label><?php echo $lang['lastName'];?> :</label>
                <input type="text" class="form-control" name="lastName" placeholder="<?php echo $lang['lastName'];?>">
            </div>
            <div class="form-group">
                <label><?php echo $lang['birth'];?> :</label>
                <input type="date" class="form-control" name="birth" placeholder="<?php echo $lang['birth'];?>">
            </div>
            <div class="form-group">
                <label><?php echo $lang['phone'];?> :</label>
                <input type="text" class="form-control" name="phone" placeholder="<?php echo $lang['phone'];?>">
            </div>
            <div class="form-group">
                <label><?php echo $lang['address'];?> :</label>
                <input type="text" class="form-control" name="adresse" placeholder="<?php echo $lang['address'];?>">
            </div>
            <div class="form-group">
                <label><?php echo $lang['city'];?> :</label>
                <input type="text" class="form-control" name="city" placeholder="<?php echo $lang['city'];?>">
            </div>
            <div class="form-group">
                <label><?php echo $lang['region'];?> : </label>
                <input type="text" class="form-control" name="region" placeholder="<?php echo $lang['region'];?>">
            </div>
            <div class="form-group">
                <label><?php echo $lang['department'];?> : </label>
                <input type="text" class="form-control" name="departement" placeholder="<?php echo $lang['department'];?>">
            </div>

            <div class="form-group">
                <label><?php echo $lang['pwd'];?> :</label>
                <input type="password" class="form-control" name="password" placeholder="<?php echo $lang['pwd'];?>">
            </div>
            <div class="form-group">
                <br>
                <input type="Submit" class="btn btn-primary" name="Submit" value="<?php echo $lang['btnSignIn'];?>">
            </div>

          </form>

  </div>


<div class="col-lg-4"></div>
</div>
  <?php include('../include/new_footer.php'); ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script type="text/javascript">

<?php if (isset($_GET['error']) && $_GET['error'] == 'name_missing') { ?>
  M.toast({html: '<?php echo $lang['error=name_missing']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'name_format') { ?>
  M.toast({html: '<?php echo $lang['error=name_format']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'prenom_missing') { ?>
  M.toast({html: '<?php echo $lang['error=prenom_missing']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'prenom_format') { ?>
  M.toast({html: '<?php echo $lang['error=prenom_format']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'email_missing') { ?>
  M.toast({html: '<?php echo $lang['error=email_missing']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'email_format') { ?>
  M.toast({html: '<?php echo $lang['error=email_format']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'email_taken') { ?>
  M.toast({html: '<?php echo $lang['error=email_taken']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'birth_missing') { ?>
  M.toast({html: '<?php echo $lang['error=birth_missing']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'phone_missing') { ?>
  M.toast({html: '<?php echo $lang['error=phone_missing']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'phone_format') { ?>
  M.toast({html: '<?php echo $lang['error=phone_format']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'adresse_missing') { ?>
  M.toast({html: '<?php echo $lang['error=adresse_missing_missing']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'departement_missing') { ?>
  M.toast({html: '<?php echo $lang['error=departement_missing']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'departement_format') { ?>
  M.toast({html: '<?php echo $lang['error=departement_format']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'city_missing') { ?>
  M.toast({html: '<?php echo $lang['error=city_missing']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'city_format') { ?>
  M.toast({html: '<?php echo $lang['error=city_format']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'region_missing') { ?>
  M.toast({html: '<?php echo $lang['error=region_missing']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'region_format') { ?>
  M.toast({html: '<?php echo $lang['error=region_format']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'password_missing') { ?>
  M.toast({html: '<?php echo $lang['error=password_missing']; ?>'});

<?php } else if (isset($_GET['error']) && $_GET['error'] == 'password_format') { ?>
  M.toast({html: '<?php echo $lang['error=password_format']; ?>'});
<?php } ?>

  </script>

</body>

</html>
