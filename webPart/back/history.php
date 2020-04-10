<?php include('../include/config.php');
  session_start();
if (!isset($_SESSION['admin'])){
header('location:../index.php');
}

$query = $pdo->prepare('SELECT * FROM DELIVERY INNER JOIN SERVICE ON SERVICE.idService = DELIVERY.idDelivery INNER JOIN PROVIDER ON PROVIDER.idProvider = DELIVERY.idProvider INNER JOIN BILL ON BILL.idBill = DELIVERY.idBill INNER JOIN USER ON USER.idUser = BILL.idUser');
$query->execute();
$resultats = $query->fetchAll();

// var_dump($resultats);
$providerCounter = 0; // pr modal

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
      
 <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Client</th>
        <th scope="col">Prestataire</th>
        <th scope="col">Service</th>
        <th scope="col">Avis</th>
        <th scope="col">Plus d'info</th>
        <!-- <th scope="col"> </th>
        <th scope="col"> </th> -->
      </tr>
    </thead>

  <?php foreach ($resultats as $delivery) { ?>
        <tbody>
          <tr>
            <!-- <form action="PHP/prestataireMAJ.php" method="POST"> -->
              <th scope="row"><?php echo $delivery['idDelivery']; ?></th>
                  <td>
                    <input type="text" class="input" name="user" value="<?php echo $delivery['userFirstName']. '  '. $delivery['userLastName']; ?>">
                  </td>
                  <td>
                    <input type="text" class="input" name="provider" value="<?php echo $delivery['providerFirstName'].'  '.$delivery['providerLastName']; ?>">
                  </td>
                  <td>
                    <input type="text" class="input" name="service" value="<?php echo $delivery['serviceTitle']; ?>">
                  </td>
                  <td>
                    <input type="text" class="input" name="avis" value="<?php echo $delivery['deliveryRate']; ?>">
                  </td>
                  
                  <td>
                    <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal-<?php echo $providerCounter; ?>">
                       + 
                    </button> -->

                    <a class="btn btn-info" target="_blank" href="../pdfGenerator.php?idBill=<?=$delivery["idBill"]?>">Facture</a>


<!-- DEBUT MODAL -->
            <!--           <div class="modal fade" id="exampleModal-<?php echo $providerCounter; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              
                              <h5 class="modal-title" id="exampleModalLabel">Facture</h5>
                              
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                               <div class="modal-content">

                                <table class="table table-hover">
                                  <thead>
                                    <tr>
                                      <th scope="col">Nom</th>
                                      <th scope="col">Date</th>
                                      <th scope="col">Description</th>
                                      <th scope="col">Prix</th>
                                      <th scope="col">Etat</th>
                                      <th scope="col"> </th>

                                    </tr>
                                  </thead>

                                      <tbody>
                                        <tr>
                                          
                                               <td>
                                                  <input type="text" class="input" name="user" value="<?php echo $delivery['userFirstName']. '  '. $delivery['userLastName']; ?>" >
                                                </td>
                                                <td>
                                                  <input type="text" class="inputDate" name="dateBill" value="<?php echo $delivery['billDate']; ?>">
                                                </td>
                                               <td>
                                                  <input type="text" id="inputEmail" name="descBill" value="<?php echo $delivery['billDescription']; ?>">
                                                </td>
                                                
                                                <td>
                                                  <input type="text" class="input" name="prix" value="<?php echo $delivery['billPrice']; ?>">
                                                </td>
                                                <td>
                                              

                                                    <?php if ($delivery['billState'] == 1){ ?>
                                                        <button class="btn btn-success"> Facture payée</button>
                                                    <?php } else { ?>
                                                       <button class="btn btn-warning"> Facture nonpayée</button>

                                                   <?php } ?>
                                                  
                                                </td>
                                          
                                        </tr>
                                      </tbody>
                                </table>
                                </div>
                                 
                          </div>
                        </div>
                      </div>

                    <?php $providerCounter++; //pr modal 
                          // }

                           ?>

 -->

<!-- FIN MODAL -->
                  </td>
                  
            <!-- </form> -->
          </tr>
        </tbody>
  <?php 
                              
        
          
        } ?>
</table>
 
</div>

<div class="col-lg-4"></div>

  <?php include('../include/footer.php'); ?>
</body>
</html>


