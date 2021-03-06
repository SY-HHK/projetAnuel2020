<?php include('../include/config.php');
  session_start();
if (!isset($_SESSION['admin'])){
header('location:../index.php');
}

$query = $pdo->prepare('SELECT * FROM DELIVERY INNER JOIN SERVICE ON SERVICE.idService = DELIVERY.idService INNER JOIN PROVIDER ON PROVIDER.idProvider = DELIVERY.idProvider INNER JOIN BILL ON BILL.idBill = DELIVERY.idBill INNER JOIN USER ON USER.idUser = BILL.idUser WHERE DELIVERY.deliveryState = 1 OR DELIVERY.deliveryState = 0');
$query->execute();
$resultats = $query->fetchAll();

$counter = 0; // pr modal

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>L'historique des préstations</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/inscription.css">
</head>

<body>

 <?php include('../include/config.php'); 

 include('../css/linkCss.php');


 include('include/headerBack.php'); 

 ?>
    
<div class="jumbotron table-responsive-xl">
  
        <h4>Les préstations réalisées</h4> 
        <hr class="my-4">

    <?php if (isset($_GET['request']) && $_GET['request'] == 1) { ?>
    <div class="alert alert-success text-center" role="alert">
        La demande spéciale a été ajoutée.
    </div>

    <?php } ?>
 <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Client</th>
        <th scope="col">Prestataire</th>
        <th scope="col">Service</th>
        <th scope="col">Avis</th>
        <th scope="col">Plus d'info</th>
      </tr>
    </thead>

  <?php foreach ($resultats as $delivery) { ?>
        <tbody>
          <tr>
              <th scope="row"><?php echo $delivery['idDelivery']; ?></th>
                  <td>
                    <input type="text" class="inputHistory" name="user" value="<?php echo $delivery['userFirstName']. '  '. $delivery['userLastName']; ?>">
                  </td>
                  <td>
                    <input type="text" class="inputHistory" name="provider" value="<?php echo $delivery['providerFirstName'].'  '.$delivery['providerLastName']; ?>">
                  </td>
                  <td>
                    <input type="text" class="inputHistory" name="service" value="<?php echo $delivery['serviceTitle']; ?>">
                  </td>
                  <td>
                    <input type="text" class="input" name="avis" value="<?php echo $delivery['deliveryRate']; ?>/5">
                  </td>
                  
                  <td>
                    <a class="btn btn-info" target="_blank" href="../pdfGenerator.php?idBill=<?=$delivery['idBill']?>&userGuid=<?=$delivery['userGuid']?>">Facture</a>
                  </td>
          </tr>
        </tbody>
  <?php } ?>
</table>
 
</div>

<div class="col-lg-4"></div>

  <?php include('../include/footer.php'); ?>
</body>
</html>


