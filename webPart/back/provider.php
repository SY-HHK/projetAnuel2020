<?php include('../include/config.php');
  session_start();
if (!isset($_SESSION['admin'])){
header('location:../index.php');
}

$query = $pdo->prepare('SELECT * FROM PROVIDER INNER JOIN CITY ON providerIdCity = idCity');
$query->execute();
$resultats = $query->fetchAll();


$providerCounter = 0; // pr modal


$query2 = $pdo->prepare('SELECT * FROM CONTRACT WHERE CONTRACT.idProvider = ?');

$query3 = $pdo->prepare('SELECT serviceTitle FROM SERVICE WHERE idService = ?');

$query4 = $pdo->prepare('SELECT * FROM SERVICE WHERE serviceValidate = 1 ');
$query4->execute();
$allServices = $query4->fetchAll();
// var_dump($allServices);
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

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'start_missing') { ?>
                <div class="alert alert-danger text-center" role="alert">
                  Vous devez indiquer la date de début du contrat
                </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'end_missing') { ?>
                <div class="alert alert-danger text-center" role="alert">
                  Vous devez indiquer la date de fin du contrat
                </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'priceContract_missing') { ?>
                <div class="alert alert-danger text-center" role="alert">
                  Vous devez indiquer un prix pour le contrat
                </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'priceContract_format') { ?>
                <div class="alert alert-danger text-center" role="alert">
                  Vous devez indiquer un prix pour le contrat supérieur à 1€
                </div>

        <?php } else if (isset($_GET['error']) && $_GET['error'] == 'contract_taken') { ?>
                <div class="alert alert-danger text-center" role="alert">
                  Ce contrat existe déjà
                </div>

         <?php } else if (isset($_GET['error']) && $_GET['error'] == 'date_format') { ?>
                <div class="alert alert-danger text-center" role="alert">
                  Vous devez revoir les dates entrées 
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

        <?php } else if (isset($_GET['deleteContract']) && $_GET['deleteContract'] == 1) { ?>
                <div class="alert alert-success text-center" role="alert">
                  <?php echo 'Le contract a été suprimé' ?>
                </div>


        <?php } else if (isset($_GET['renew']) && $_GET['renew'] == 1) { ?>
                <div class="alert alert-success text-center" role="alert">
                  <?php echo 'Le contract a été renouvelé' ?>
                </div>

        <?php } else if (isset($_GET['addContract']) && $_GET['addContract'] == 1) { ?>
                <div class="alert alert-success text-center" role="alert">
                  <?php echo 'Le contract a été ajouté !' ?>
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
        <!-- <th scope="col">Avis</th> -->
        <th scope="col">Pénalités</th>
        <th scope="col">State</th>
        <th scope="col">Plus d'info</th>
        <th scope="col"> </th>
         <th scope="col"> </th>
      </tr>
    </thead>

  <?php foreach ($resultats as $provider) { ?>
        <tbody>
          <tr>
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
                  <!-- <td>
                    <input type="text" class="inputNbr" name="providerRate" value="<?php echo $provider['providerRate']; ?>">
                  </td> -->
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
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal-<?php echo $providerCounter; ?>">
                       + 
                    </button>

<!-- DEBUT MODAL -->
                      <div class="modal fade" id="exampleModal-<?php echo $providerCounter; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <?php echo $provider['providerLastName']; ?>
                        <div class="modal-dialog modal-xl" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              
                              <h5 class="modal-title" id="exampleModalLabel">Informations complémentaires sur M.<?php echo $provider['providerLastName']; ?></h5>
                              
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <?php 
                              if ($provider['providerRate'] == NULL){
                                echo "Ce prestataire n'a pas recu d'avis par nos clients";
                              }else{
                              echo "L'avis sur ce prestataire par nos client : ". $provider['providerRate'] . "/10"; 
                              }?>
                                <hr class="my-4">

                              <?php 
                                $query2->execute([$provider["idProvider"]]);
                                $resultats2 = $query2->fetchAll();

                                // var_dump($resultats2);

                                // if ($resultats2 == NULL){
                                //   echo "Ce prestataire n'a pas de contract en cours. ";

                                // } else {

                                
                                 ?>

                                  
                              
                                  <div class="card">
                                  <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                      <button class=" btn collaborateur " type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" >
                                        <h6>Les contats en cours </h6>
                                      </button>
                                    </h2>
                                  </div>


                                    <div class="accordion" id="accordionExample">
                                      <div class="card">
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                          <div class="card-body">

                                            <table class="table table-hover">
                                              <?php
                                                if ($resultats2 == NULL){
                                                    echo "Ce prestataire n'a pas de contract";
                                                   } else {
                                              ?>
                                                  <thead>
                                                    <tr>
                                                      <th scope="col">start</th>
                                                      <th scope="col">end</th>
                                                      <th scope="col">€/heure</th>
                                                      <th scope="col">service</th>
                                                      <th scope="col"> </th>
                                                      <th scope="col"> </th>

                                                    </tr>
                                                  </thead>
                                                   <?php     

                                                 
                                                    foreach ($resultats2 as $contract) {

                                                          $query3->execute([$contract['idService']]);
                                                          $service = $query3->fetch();
                                                           // var_dump($service);
                                                    ?>

                                                    
                                                                  <tr>
                                                                          <td>
                                                                            <input type="hidden" class="input" name="idContract" value="<?php echo $contract['idContract']; ?>">

                                                                            <input type="date" class="inputContract" name="hello" value="<?php echo $contract['contractDateStart']; ?>" disabled="disabled">
                                                                          </td>
                                                                          <td>
                                                                            <input type="date" class="inputContract" name="end" value="<?php echo $contract['contractDateEnd']; ?>" disabled="disabled">
                                                                          </td>
                                                                          <td>
                                                                            <input type="text" class="inputNbr" name="price" value="<?php echo $contract['contractPrice']; ?>" disabled="disabled">
                                                                          </td>
                                                                          <td>
                                                                            <input type="text" class="inputContract" name="service" value="<?php echo $service['serviceTitle']; ?>" disabled="disabled">
                                                                          </td>
                                                                          <td>
                                                                            <a class="btn btn-secondary" href="PHP/prestataireMAJ.php?idContract=<?php echo $contract['idContract']; ?>&start=<?php echo $contract['contractDateStart']; ?>&end= <?php echo $contract['contractDateEnd'];?>">renew</a>
                                                                          </td>
                                                                          <td>
                                                                            <input type="hidden" class="input" name="idContract" value="<?php echo $contract['idContract']; ?>">
                                                                            <a class="" href="PHP/prestataireMAJ.php?deleteContract=<?php echo $contract['idContract']; ?>">X</a>

                                                                            <!-- <input type="submit" name="deleteContract" class="option"value="X"> -->
                                                                          </td>
                                                                         
                                                                  </tr>
                                                     
                                                    <?php }
                                                    } ?>
                                                  
                                                </table>
                                               </div>
                                              </div>
                                            </div>
                                            <div class="card">
                                              <div class="card-header" id="headingTwo">
                                                <h2 class="mb-0">
                                                  <button class="btn collaborateur collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    <h6>Ajouter un contrat</h6>
                                                  </button>
                                                </h2>
                                              </div>
                                              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                <div class="card-body"> 
                                                   <table class="table table-hover">
                                                  <thead>
                                                    <tr>
                                                      <th scope="col">start</th>
                                                      <th scope="col">end</th>
                                                      <th scope="col">€/heure</th>
                                                      <th scope="col">service</th>
                                                      <th scope="col"> </th>
                                                    </tr>
                                                  </thead>
                                                  
                                                    <tr>
                                                            <td>
                                                              <input type="date" class="inputContract" name="startContract">
                                                            </td>
                                                            <td>
                                                              <input type="date" class="inputContract" name="endContract">
                                                            </td>
                                                            <td>
                                                              <input type="text" class="inputNbr" name="priceContract" placeholder="...">
                                                            </td>
                                                            <td>
                                                               <div class="form-group">
                                                                  <select class="form-control-sm" name="idService">

                                                                    <?php foreach ($allServices as $service) { ?>
                                                                     
                                                                    <option value="<?php echo $service['idService']; ?>"><?php echo $service['serviceTitle']; ?></option>


                                                                    <?php } ?>
                                                                  </select>
                                                                </div>
                                                              <!-- <input type="text" class="input" name="serviceContract" placeholder="..."> -->
                                                            </td>
                                                            <td>
                                                              <input type="hidden" name="idProvider" value="<?php echo $provider['idProvider']; ?>">
                                                              <input type="submit" name="addContract" class="option" value="Ajouter !">
                                                            </td>
                                                    </tr>
                                               
                                            </table>
                                            </div>
                                          </div>
                                        </div>      
                              </div>
                          </div>
                        </div>
                      </div>

                    <?php $providerCounter++; //pr modal 
                          // }

                           ?>
<!-- FIN MODAL -->
                  </td>
                  <td>                    
                    <input type="submit" name="pwd" class="btn btn-primary" value="MDP">
                  </td>
                  <td>
                    <input type="hidden" name="idProvider" value="<?php echo $provider['idProvider']; ?>">
                    <input type="submit" name="updateProvider" class="btn btn-warning"value="MAJ">
                  </td>
            </form>
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


