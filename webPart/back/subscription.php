<?php include('../include/config.php');
  session_start();

$query = $pdo->prepare('SELECT * FROM SUBSCRIPTION');
$query->execute();

$resultats = $query->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Les abonnements</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/inscription.css">
</head>

<body>

 <?php
 include('../include/config.php');

 include('../css/linkCss.php');

 include('include/headerBack.php');

 ?>

<div class="jumbotron table-responsive-xl">

        <h4>Les abonnements</h4>
        <hr class="my-4">


         <?php if (isset($_GET['error']) && $_GET['error'] == 'name_missing') { ?>
          <div class="alert alert-danger text-center" role="alert">
            Vous devez indiquez le nom
          </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'name_format') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Veuillez revoir le nom
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'price_missing') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Vous devez indiquer le prix
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'price_format') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Veuillez revoir le prix (minimum 100€/ans)
                  </div>
        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'hour_missing') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Vous devez indiquer le nombre d'heures par mois
                  </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'hour_format') { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    Veuillez revoir le prix (max 730h/mois)
                  </div>
        <?php } else if (isset($_GET['update']) && $_GET['update'] == 1) { ?>
              <div class="alert alert-success text-center" role="alert">
            Modification(s) enregistrée(s)
          </div>
           <?php } else if (isset($_GET['add']) && $_GET['add'] == 'ok') { ?>
              <div class="alert alert-success text-center" role="alert">
           Abonnement ajouté !
          </div>
        <?php } else if (isset($_GET['delete']) && $_GET['delete'] == 1 && isset($_GET['id']) && !empty($_GET['id'])) { ?>
            <div class="alert alert-success text-center" role="alert">
            <?php echo 'L\'id '.$_GET['id'].' a été suprimée' ?>
          </div>

        <?php } ?>


<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn collaborateur" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Les abonnements
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
                <th scope="col">- J/7</th>
                <th scope="col">Heure début</th>
                <th scope="col">Heure fin</th>
                <th scope="col">Heures/mois</th>
                <th scope="col"> € TTC/an</th>
                <th scope="col"> </th>
                <th scope="col"> </th>

              </tr>
            </thead>
          <?php
              foreach ($resultats as $sub) { ?>
                <tbody>
                  <tr <?php if (isset($_GET['subSelected']) && $_GET['subSelected'] == $sub['idSub']){ echo 'class="table-active"'; }?>>
                    <form action="PHP/subMAJ.php" method="POST">
                      <th scope="row"><?php echo $sub['idSub']; ?></th>
                          <td>
                            <input type="text" class="input" name="name" value="<?php echo $sub['subName']; ?>">
                          </td>
                          <td>
                            <div class="form-group">
                              <select class="form-control-sm" name="days">

                                  <?php for  ($i = 1; $i <= 7; $i++){ ?>
                                        <option <?php if ($sub['subDays'] == $i){ echo 'selected'; }?>><?php echo $i; ?></option>
                                  <?php } ?>
                              </select>
                            </div>
                          </td>
                          <td>
                             <div class="form-group">
                              <select class="form-control-sm" name="start">
                                  <?php for  ($i = 1; $i <= 24; $i++){ ?>
                                      <option <?php if ($sub['subHourStart'] == $i){ echo 'selected'; }?>><?php echo $i; ?></option>
                                  <?php } ?>
                              </select>
                            </div>
                          </td>
                          <td>
                             <div class="form-group">
                              <select class="form-control-sm" name="end">
                                  <?php for  ($i = 1; $i <= 24; $i++){ ?>
                                      <option <?php if ($sub['subHourEnd'] == $i){ echo 'selected'; }?>><?php echo $i; ?></option>
                                  <?php } ?>
                              </select>
                            </div>
                          </td>
                          <td>
                             <input type="text" class="input" name="hour" value="<?php echo $sub['subHour']; ?>">
                          </td>
                          <td>
                            <input type="text" class="input" name="price" value="<?php echo $sub['subPrice']; ?>">
                          </td>

                          <td>
                            <input type="hidden" name="idSub" value="<?php echo $sub['idSub']; ?>">
                            <input type="submit" name="updateSub" class = "btn btn-warning" value="MAJ">
                          </td>
                          <td>
                            <input type="hidden" name="idSub" value="<?php echo $sub['idSub']; ?>">
                            <input type="submit" name="delete" class="btn btn-outline-danger "value="X">
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
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn collaborateur collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Ajouter un abonnement
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Nom</th>
                <th scope="col">- J/7</th>
                <th scope="col">Heure début</th>
                <th scope="col">Heure fin</th>
                <th scope="col">Heures/mois</th>
                <th scope="col"> € TTC/an</th>
                <th scope="col"> </th>

              </tr>
            </thead>

                <tbody>
                  <tr>
                    <form action="PHP/subMAJ.php" method="POST">
                          <td>
                            <input type="text" class="input" name="name" placeholder="... ">
                          </td>
                          <td>
                            <div class="form-group">
                              <select class="form-control-sm" name="days">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                              </select>
                            </div>
                          </td>
                          <td>
                             <div class="form-group">
                              <select class="form-control-sm" name="start">

                                  <?php for ($i = 1; $i <=24; $i++) { ?>
                                        <option><?php echo $i; ?></option>
                                  <?php  } ?>
                              </select>
                            </div>
                          </td>
                          <td>
                             <div class="form-group">
                              <select class="form-control-sm" name="end">

                                  <?php for ($i = 1; $i <=24; $i++) { ?>
                                      <option><?php echo $i; ?></option>
                                  <?php  } ?>
                              </select>
                            </div>
                          </td>
                          <td>
                             <input type="text" class="input" name="hour" placeholder="...">
                          </td>
                          <td>
                            <input type="text" class="input" name="price" placeholder="...">
                          </td>
                          <td>
                            <input type="submit" name="addSub" class="btn btn-success" value="Ajouter !">
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
