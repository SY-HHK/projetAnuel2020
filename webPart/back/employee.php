<?php include('../include/config.php');
  session_start();
if (!isset($_SESSION['admin'])){
header('location:../index.php');
}

$query = $pdo->prepare('SELECT * FROM EMPLOYEE');
$query->execute();

$resultats = $query->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Les comptes pde nos collaborateurs</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/inscription.css">
</head>

<body>

 <?php include('../include/config.php'); 

 include('../css/linkCss.php');


 include('include/headerBack.php'); 

 ?>
    
<div class="jumbotron table-responsive-xl">

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


        <?php } else if (isset($_GET['genere']) && $_GET['genere'] == 1) { ?>
                  <div class="alert alert-success text-center" role="alert">
                    Le nouveau mot de passe a été généré
                  </div>

                <?php } else if (isset($_GET['add']) && $_GET['add'] == 'ok') { ?>
              <div class="alert alert-success text-center" role="alert">
            Collaborateur ajouté ! 
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
      


  <div class="accordion" id="accordionExample">
    <div class="card">
      <div class="card-header" id="headingOne">
        <h2 class="mb-0">
          <button class=" btn collaborateur " type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" >
            Nos collaborateur
          </button>
        </h2>
      </div>

      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body">
          <table class="table table-hover table-dark">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Prénom</th>
                  <th scope="col">Nom</th>
                  
                  <th scope="col">Email</th>
                  
                  <th scope="col">MDP</th>
                   <th scope="col"> </th>
                </tr>
              </thead>



              <?php
                  foreach ($resultats as $employee) { ?>
                    <tbody>
                      <tr>
                        <form action="PHP/employeeMAJ.php" method="POST">
                          <th scope="row"><?php echo $employee['idEmployee']; ?></th>
                              <td>
                                <input type="text" name="firstName" value="<?php echo $employee['employeeFirstName']; ?>" readonly>
                              </td>
                              <td>
                                <input type="text"  name="lastName" value="<?php echo $employee['employeeLastName']; ?>" readonly>
                              </td>
                              
                              <td>
                                <input type="text"  name="mail" value="<?php echo $employee['employeeEmail']; ?>" readonly>
                              </td>
                              
                              
                              <td> 
                                <input type="hidden" name="idEmployee" value="<?php echo $employee['idEmployee']; ?>">                   
                                <input type="submit" name="pwd" class="option" value="NEW">
                             </td>
                              <td>
                                <input type="submit" name="delete" class="option"value="X">
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
            Ajouter un collaborateur
          </button>
        </h2>
      </div>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <div class="card-body">
          
          <table class="table table-hover table-dark">
              <thead>
                <tr>
                  <th scope="col">Prénom</th>
                  <th scope="col">Nom</th>
                  <th scope="col">Email</th>
                  <th scope="col"> </th>
                </tr>
              </thead>

                    <tbody>
                      <tr>
                        <form action="PHP/addEmployee.php" method="POST">
                          
                              <td>
                                <input type="text" name="firstName" placeholder="Prénom">
                              </td>
                              <td>
                                <input type="text"  name="lastName" placeholder="Nom">
                              </td>
                              <td>
                                <input type="text"  name="mail" placeholder="Adresse mail">
                              </td>
                              <td>
                                <input type="submit" name="add" value="Ajouter !">
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


