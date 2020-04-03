<?php include('../include/config.php');
  session_start();
if (!isset($_SESSION['admin'])){
header('location:../index.php');
}
//var_dump($_SESSION['admin']);
$query = $pdo->prepare('SELECT * FROM SERVICE WHERE serviceValidate = 1');
$query->execute();

$resultats = $query->fetchAll();


$query2 = $pdo->prepare('SELECT * FROM SERVICE WHERE serviceValidate = 2');
$query2->execute();

$resultats2 = $query2->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Les services</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/inscription.css">
</head>

<body>

 <?php include('../include/config.php');



 include('include/headerBack.php');

 ?>

<div class="jumbotron table-responsive-xl">

        <h4>Les services</h4>
        <hr class="my-4">


         <?php if (isset($_GET['error']) && $_GET['error'] == 'name_missing') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Vous devez indiquez le nom
          </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'price_missing') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Vous devez indiquer le prix
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'name_format') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Veuillez revoir le nom
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'description_missing') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Vous devez indiquer la description
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'price_format') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Veuillez revoir le prix (min 3€ l'heure)
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'file_type') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Veuillez revoir le format de l'image (png, jpeg, gif, jpg)
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'file_size') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Attention taille maximum image 2Mo
                  </div>

        <?php } else if (isset($_GET['update']) && $_GET['update'] == 1) { ?>
              <div class="alert alert-success text-center" role="alert">
            Modification(s) enregistrée(s)
          </div>
        <?php } else if (isset($_GET['request']) && $_GET['request'] == 1) { ?>
              <div class="alert alert-success text-center" role="alert">
            La demande spéciale a été ajoutée.
          </div>

        <?php } else if (isset($_GET['add']) && $_GET['add'] == 'ok') { ?>
              <div class="alert alert-success text-center" role="alert">
           Service ajouté !
          </div>

        <?php } else if (isset($_GET['delete']) && $_GET['delete'] == 1 && isset($_GET['id']) && !empty($_GET['id'])) { ?>
            <div class="alert alert-success text-center" role="alert">
            <?php echo 'Le service a été suprimée' ?>
          </div>

        <?php } ?>


<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn collaborateur" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Nos services
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">€/heure</th>
                <th scope="col">Description</th>
                <th scope="col">Image</th>
                <th scope="col"></th>
                <th scope="col"> </th>

              </tr>
            </thead>
          <?php
              foreach ($resultats as $service) { ?>
                <tbody>
                  <tr>
                    <form action="PHP/serviceMAJ.php" method="POST" enctype="multipart/form-data">
                      <th scope="row"><img src="<?php echo $service['serviceImage']; ?>" id="image"></th>
                          <td>
                            <input type="text" class="inputDelivery" name="name" value="<?php echo $service['serviceTitle']; ?>">
                          </td>
                          <td>
                            <input type="text" class="inputNbr" name="price" value="<?php echo $service['servicePrice']; ?>">
                          </td>
                          <td>
                            <textarea id="desc" type="text" name="description" ><?php echo $service['serviceDescription']; ?></textarea>
                          </td>
                          <td>
                            <input type="file" class="form-control-file file-upload" name="image" value="<?php echo $service['serviceImage']; ?>">
                          </td>
                          <td>
                            <input type="hidden" name="idService" value="<?php echo $service['idService']; ?>">
                            <input type="submit" name="updateSub" class="btn btn-warning"value="MAJ">
                          </td>
                          <td>
                            <input type="hidden" name="idSub" value="<?php echo $service['idService']; ?>">
                            <input type="hidden" name="verifPhoto" value="<?php echo $service['serviceImage']; ?>">

                            <input type="submit" name="delete" class="btn btn-outline-danger"value="X">
                          </td>
                    </form>
                  </tr>
                </tbody>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>

    <div class="card">
    <div class="card-header" id="headingtwo">
      <h2 class="mb-0">
        <button class="btn collaborateur" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          Nos demandes spéciales
        </button>
      </h2>
    </div>

    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">€/heure</th>
                <th scope="col">Description</th>
                <th scope="col">Image</th>
                <th scope="col"></th>
                <th scope="col"> </th>

              </tr>
            </thead>
          <?php
              foreach ($resultats2 as $service) { ?>
                <tbody>
                  <tr>
                    <form action="PHP/serviceMAJ.php" method="POST" enctype="multipart/form-data">
                      <th scope="row"><img src="<?php echo $service['serviceImage']; ?>" id="serviceImage"></th>
                          <td>
                            <input type="text" class="inputDelivery" name="name" value="<?php echo $service['serviceTitle']; ?>">
                          </td>
                          <td>
                            <input type="text" class="inputNbr" name="price" value="<?php echo $service['servicePrice']; ?>" >
                          </td>
                          <td>
                            <textarea id="desc" type="text" name="description" ><?php echo $service['serviceDescription']; ?></textarea>
                          </td>
                          <td>
                            <input type="file" class="form-control-file" name="image">
                          </td>
                          <td>
                            <input type="hidden" name="idService" value="<?php echo $service['idService']; ?>">
                            <input type="submit" name="updateSub" class="btn btn-warning"value="MAJ">
                          </td>
                          <td>
                            <input type="hidden" name="verifPhoto" value="<?php echo $service['serviceImage']; ?>">
                            <input type="hidden" name="idSub" value="<?php echo $service['idService']; ?>">
                            <input type="submit" name="delete" class="btn btn-outline-danger"value="X">
                          </td>
                    </form>
                  </tr>
                </tbody>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn collaborateur collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Ajouter un service
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Nom</th>
                <th scope="col">€/heure</th>
                <th scope="col">Description</th>
                <th scope="col">Image</th>
                <th scope="col"> </th>

              </tr>
            </thead>

                <tbody>
                  <tr>
                    <form action="PHP/serviceMAJ.php" method="POST" enctype="multipart/form-data">
                         <td>
                            <input type="text" class="input" name="name" placeholder="... ">
                          </td>
                         <td>
                            <input type="text" class="input" name="price" placeholder="...">
                          </td>
                          <td>
                            <textarea id="desc" type="text" name="description" ></textarea>
                          </td>
                          <td>
                          <input type="file" class="form-control-file" name="image">
                          </td>
                          <td>
                            <input type="submit" name="addService" class="btn btn-success" value="Ajouter !">
                          </td>
                    </form>
                  </tr>
                </tbody>
          </table>

      </div>
    </div>
  </div>
</div>




</div>

<div class="col-lg-4"></div>

  <?php include('../include/footer.php'); ?>
</body>
</html>
