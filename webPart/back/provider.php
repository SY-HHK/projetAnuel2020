<?php include('../include/config.php');
  session_start();
if (!isset($_SESSION['admin'])){
header('location:../index.php');
}

$query = $pdo->prepare('SELECT * FROM PROVIDER');
$query->execute();

$resultats = $query->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Les comptes prestataires</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/inscription.css">
</head>

<body>

 <?php include('../include/config.php'); 

 include('../css/linkCss.php');


 include('include/headerBack.php'); 

 ?>
    
<div class="jumbotron table-responsive-xl">
  
        <h4>Nos prestataires</h4> 
        <hr class="my-4">
        <?php if (isset($_GET['error']) && $_GET['error'] == 'name_missing') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Vous devez indiquez le nom
          </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'name_format') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Veuillez revoir le nom
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'prenom_missing') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Vous devez indiquer le prenom
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'prenom_format') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Veuillez revoir le prenom
                  </div> 
        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'phone_missing') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Vous devez indiquer le numéro de téléphone
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'phone_format') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Veuillez revoir le numéro de téléphone
                  </div> 

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'email_missing') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                     Vous devez indiquez l'adresse mail
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'email_format') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Veuillez revoir  l'adresse mail
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'email_taken') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                 Cette adresse mail existe déjà dans notre base de données
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'adresse_missing') { ?>
                <div class="alert alert-danger text-center" role="alert">
                 Vous devez entrer une adresse
                </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'departement_missing') { ?>
                <div class="alert alert-danger text-center" role="alert">
                 Vous devez entrer un département
                </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'departement_format') { ?>
        <div class="alert alert-danger text-center" role="alert">
         Vous devez entrer un département valide
        </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'city_missing') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Vous devez indiquer une ville
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'city_format') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Veuillez revoir la ville
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'region_missing') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Vous devez indiquer une région
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'region_format') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Veuillez revoir la région
                  </div>

        <?php } else if (isset($_GET['genere']) && $_GET['genere'] == 1) { ?>
                  <div class="alert alert-success text-center" role="alert">
                    Le nouveau mot de passe a été généré
                  </div>
 
            <?php } else if (isset($_GET['update']) && $_GET['update'] == 1) { ?>
              <div class="alert alert-success text-center" role="alert">
            Modification(s) enregistrée(s)
          </div>
          <?php } else if (isset($_GET['delete']) && $_GET['delete'] == 1 && isset($_GET['id']) && !empty($_GET['id'])) { ?>
            <div class="alert alert-success text-center" role="alert">
            <?php echo 'L\'id '.$_GET['id'].' a été suprimée' ?>
          </div>
        <?php } ?>
      
 <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Prénom</th>
        <th scope="col">Nom</th>
        <th scope="col">Numéro tél.</th>
        <th scope="col">Email</th>
        <th scope="col">Adresse</th>
        <th scope="col">Ville</th>
        <th scope="col">Région</th>
        <th scope="col">Départ.</th>
        <th scope="col">Entreprise</th>
        <th scope="col">Avis</th>
        <th scope="col">Pénalités</th>
        <th scope="col">State</th>
        <th scope="col">MDP</th>
         <th scope="col">MAJ</th>
      </tr>
    </thead>

  <?php
      foreach ($resultats as $provider) { ?>
        <tbody>
          <tr <?php if ($provider['state'] == 0) echo 'class = "table-success"'; 
           else if($provider['state'] == 1) echo 'class = "table-warning"';?>>
            <form action="PHP/prestataireMAJ.php" method="POST">
              <th scope="row"><?php echo $provider['idProvider']; ?></th>
                  <td>
                    <input type="text" class="input" name="firstName" value="<?php echo $provider['providerFirstName']; ?>">
                  </td>
                  <td>
                    <input type="text" class="input" name="lastName" value="<?php echo $provider['providerLastName']; ?>">
                  </td>
                  <td>
                    <input type="text" placeholder= "0123456789" class="input" name="phone" value="<?php echo $provider['providerPhone']; ?>">
                  </td>
                  <td>
                    <input type="text" class="inputEmail" name="mail" value="<?php echo $provider['providerEmail']; ?>">
                  </td>
                  <td>
                    <input type="text" class="input" name="adresse" value="<?php echo $provider['providerAddress']; ?>">
                  </td>
                  <td>
                    <input type="text" class="input" name="city" value="<?php echo $provider['cityName']; ?>">
                  </td>
                  <td>
                    <input type="text" class="input" name="region" value="<?php echo $provider['cityRegion']; ?>">
                  </td>
                  <td>
                    <input type="text" class="inputNbr" name="departement" value="<?php echo $provider['cityDepartement']; ?>">
                  </td>
                  <td>
                    <input type="text" class="input" name="companyName" value="<?php echo $provider['companyName']; ?>">
                  </td>
                  <td>
                    <input type="text" class="inputNbr" name="providerRate" value="<?php echo $provider['providerRate']; ?>">
                  </td>
                  <td>
                    <input type="text" class="inputNbr" name="annulation" value="<?php echo $provider['providerAnnulation']; ?>">
                  </td>
                  <td>
                    <div class="form-group">
                      <select class="form-control-sm" name="state">
                        <option <?php if ($provider['state'] == 0 ){ echo 'selected'; }?>>A</option>
                        <option <?php if ($provider['state'] == 1){ echo 'selected'; }?>>V</option>
                        <option <?php if ($provider['state'] == 2){ echo 'selected'; }?>>S</option>
                      </select>
                    </div>
                  </td>
                  <td>                    
                    <input type="submit" name="pwd" class="option" value="NEW">
                 </td>
                  <td>
                    <input type="hidden" name="idProvider" value="<?php echo $provider['idProvider']; ?>">
                    <input type="submit" name="updateProvider" class="option"value="MAJ">
                  </td>
            </form>
          </tr>
        </tbody>
  <?php } ?>
</table>
 
</div>

<div class="col-lg-4"></div>

  <?php include('../include/footer.php'); ?>
</body>
</html>


