<?php include('../include/config.php');
  session_start();
if (!isset($_SESSION['admin'])){
header('location:../index.php');
}
//var_dump($_SESSION['admin']);
$query = $pdo->prepare('SELECT * FROM DELIVERY INNER JOIN BILL on BILL.idBill = DELIVERY.idBILL INNER JOIN USER on USER.idUser = BILL.idUser WHERE DELIVERY.deliveryState = 2');
$query->execute();

$resultats = $query->fetchAll();


$query4 = $pdo->prepare('SELECT * FROM SERVICE ');
$query4->execute();
$allServices = $query4->fetchAll();

//var_dump($resultats);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Les demandes</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/inscription.css">
</head>

<body>

<?php 
  include('../include/config.php');
  include('include/headerBack.php');
?>

<div class="jumbotron table-responsive-xl">

        <h4>Les demandes spéciales</h4>
        <hr class="my-4">


      <?php if(isset($_GET['request']) && $_GET['request'] == 1) { ?>
            <div class="alert alert-success text-center" role="alert">
            <?php echo 'La demande a été refusée' ?>
          </div>

    <?php } else if(isset($_GET['error']) && $_GET['error'] == 'hourEnd') { ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php echo ' L\'heure de fin de la préstation est obligatoire' ?>
        </div>

      <?php } else if(isset($_GET['error']) && $_GET['error'] == 'dateEnd') { ?>
          <div class="alert alert-danger text-center" role="alert">
              <?php echo 'La date de fin de préstation est à indiquer ou à revoir' ?>
          </div>

    <?php } ?>




<div class="accordion" id="accordionExample">
  <div class="card">

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <table class="table table-hover">
            <thead>
              <tr>
                    <th scope="col">Client</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date début</th>
                    <th scope="col">Heure début</th>
                    <th scope="col">Date fin</th>
                    <th scope="col">Heure fin</th>
                    <th scope="col">Liéer à un autre service</th>
                    <th scope="col">Décision</th>
                    <th scope="col"> </th>
              </tr>
            </thead>
          <?php
              foreach ($resultats as $demande) { ?>
                <tbody>
                  <tr>
                    <form action="PHP/requestValidation.php" method="POST">
                         <td>
                            <input type="text" class="inputRequest" name="user" value="<?php echo $demande['userLastName']; ?>" disabled>
                         </td>

                        <td>
                            <textarea id="descRequest" type="text" name="description" ><?php echo $demande['billDescription']; ?></textarea>
                        </td>
                     
                        <td>
                            <input type="date" class="inputDate" name="dateStart" value="<?php echo $demande['deliveryDateStart']; ?>">
                        </td>

                        <td>
                            <input type="time" class="inputTime" name="hourStart" value="<?php echo $demande['deliveryHourStart']; ?>">
                        </td>

                        <td>
                            <input type="date" class="inputDate" name="dateEnd" value="<?php echo $demande['deliveryDateEnd']; ?>">
                        </td>

                        <td>
                            <input type="time" class="inputTime" name="hourEnd" value="<?php if ($demande['deliveryHourEnd'] == NULL )echo '--'; else echo $demande['deliveryHourEnd']; ?>">
                        </td>

                        <td>
                            <div class="form-group">
                                <select class="form-control-sm" name="idService">
                                    <?php foreach ($allServices as $service) { ?>
                                        <option value="<?php echo $service['idService']; ?>"><?php echo $service['serviceTitle']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                              <select class="form-control-sm" name="state">
                                <option value="1">Valider</option>
                                <option value="0">Refuser</option>
                              </select>
                            </div>
                        </td>
                        <td>
                            <input type="hidden" name="idDelivery" value="<?php echo $demande['idDelivery']; ?>">
                            <input type="hidden" name="idBill" value="<?php echo $demande['idBill']; ?>">

                            <input type="submit" class="btn btn-success" name="enregistrer" value="valider">
                        </td>
                    </form>
                  </tr>
                </tbody>
          <?php } ?>
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
