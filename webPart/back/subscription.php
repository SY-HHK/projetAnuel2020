<?php include('../include/config.php');
  session_start();
if (!isset($_SESSION['admin'])){
header('location:../index.php');
}

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

 <?php include('../include/config.php'); 

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
        <table class="table table-hover table-dark">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">- J/7</th>
                <th scope="col">Heure début</th>
                <th scope="col">Heure fin</th>
                <th scope="col">Heures/mois</th>
                <th scope="col"> € TTC/an</th>
                <th scope="col">MAJ</th>
                <th scope="col"> </th>

              </tr>
            </thead>
          <?php
              foreach ($resultats as $sub) { ?>
                <tbody>
                  <tr>
                    <form action="PHP/subMAJ.php" method="POST">
                      <th scope="row"><?php echo $sub['idSub']; ?></th>
                          <td>
                            <input type="text" class="input" name="name" value="<?php echo $sub['subName']; ?>">
                          </td>
                          <td>
                            <div class="form-group">
                              <select class="form-control-sm" name="days">
                                <option <?php if ($sub['subDays'] == 1){ echo 'selected'; }?>>1</option>
                                <option <?php if ($sub['subDays'] == 2){ echo 'selected'; }?>>2</option>
                                <option <?php if ($sub['subDays'] == 3){ echo 'selected'; }?>>3</option>
                                <option <?php if ($sub['subDays'] == 4){ echo 'selected'; }?>>4</option>
                                <option <?php if ($sub['subDays'] == 5){ echo 'selected'; }?>>5</option>
                                <option <?php if ($sub['subDays'] == 6){ echo 'selected'; }?>>6</option>
                                <option <?php if ($sub['subDays'] == 7){ echo 'selected'; }?>>7</option>
                              </select>
                            </div>
                          </td>
                          <td>
                             <div class="form-group">
                              <select class="form-control-sm" name="start">
                                <option <?php if ($sub['subHourStart'] == 1){ echo 'selected'; }?>>1</option>
                                <option <?php if ($sub['subHourStart'] == 2){ echo 'selected'; }?>>2</option>
                                <option <?php if ($sub['subHourStart'] == 3){ echo 'selected'; }?>>3</option>
                                <option <?php if ($sub['subHourStart'] == 4){ echo 'selected'; }?>>4</option>
                                <option <?php if ($sub['subHourStart'] == 5){ echo 'selected'; }?>>5</option>
                                <option <?php if ($sub['subHourStart'] == 6){ echo 'selected'; }?>>6</option>
                                <option <?php if ($sub['subHourStart'] == 7){ echo 'selected'; }?>>7</option>
                                <option <?php if ($sub['subHourStart'] == 8){ echo 'selected'; }?>>8</option>
                                <option <?php if ($sub['subHourStart'] == 9){ echo 'selected'; }?>>9</option>
                                <option <?php if ($sub['subHourStart'] == 10){ echo 'selected';}?>>10</option>
                                <option <?php if ($sub['subHourStart'] == 11){ echo 'selected';}?>>11</option>
                                <option <?php if ($sub['subHourStart'] == 12){ echo 'selected';}?>>12</option>
                                <option <?php if ($sub['subHourStart'] == 13){ echo 'selected';}?>>13</option>
                                <option <?php if ($sub['subHourStart'] == 14){ echo 'selected';}?>>14</option>
                                <option <?php if ($sub['subHourStart'] == 15){ echo 'selected';}?>>15</option>
                                <option <?php if ($sub['subHourStart'] == 16){ echo 'selected';}?>>16</option>
                                <option <?php if ($sub['subHourStart'] == 17){ echo 'selected';}?>>17</option>
                                <option <?php if ($sub['subHourStart'] == 18){ echo 'selected';}?>>18</option>
                                <option <?php if ($sub['subHourStart'] == 19){ echo 'selected';}?>>19</option>
                                <option <?php if ($sub['subHourStart'] == 20){ echo 'selected';}?>>20</option>
                                <option <?php if ($sub['subHourStart'] == 21){ echo 'selected';}?>>21</option>
                                <option <?php if ($sub['subHourStart'] == 22){ echo 'selected';}?>>22</option>
                                <option <?php if ($sub['subHourStart'] == 23){ echo 'selected';}?>>23</option>
                                <option <?php if ($sub['subHourStart'] == 24){ echo 'selected'; }?>>24</option>
                              </select>
                            </div>
                          </td>
                          <td>
                             <div class="form-group">
                              <select class="form-control-sm" name="end">
                                <option <?php if ($sub['subHourEnd'] == 1){ echo 'selected'; }?>>1</option>
                                <option <?php if ($sub['subHourEnd'] == 2){ echo 'selected'; }?>>2</option>
                                <option <?php if ($sub['subHourEnd'] == 3){ echo 'selected'; }?>>3</option>
                                <option <?php if ($sub['subHourEnd'] == 4){ echo 'selected'; }?>>4</option>
                                <option <?php if ($sub['subHourEnd'] == 5){ echo 'selected'; }?>>5</option>
                                <option <?php if ($sub['subHourEnd'] == 6){ echo 'selected'; }?>>6</option>
                                <option <?php if ($sub['subHourEnd'] == 7){ echo 'selected'; }?>>7</option>
                                <option <?php if ($sub['subHourEnd'] == 8){ echo 'selected'; }?>>8</option>
                                <option <?php if ($sub['subHourEnd'] == 9){ echo 'selected'; }?>>9</option>
                                <option <?php if ($sub['subHourEnd'] == 10){ echo 'selected';}?>>10</option>
                                <option <?php if ($sub['subHourEnd'] == 11){ echo 'selected';}?>>11</option>
                                <option <?php if ($sub['subHourEnd'] == 12){ echo 'selected';}?>>12</option>
                                <option <?php if ($sub['subHourEnd'] == 13){ echo 'selected';}?>>13</option>
                                <option <?php if ($sub['subHourEnd'] == 14){ echo 'selected';}?>>14</option>
                                <option <?php if ($sub['subHourEnd'] == 15){ echo 'selected';}?>>15</option>
                                <option <?php if ($sub['subHourEnd'] == 16){ echo 'selected';}?>>16</option>
                                <option <?php if ($sub['subHourEnd'] == 17){ echo 'selected';}?>>17</option>
                                <option <?php if ($sub['subHourEnd'] == 18){ echo 'selected';}?>>18</option>
                                <option <?php if ($sub['subHourEnd'] == 19){ echo 'selected';}?>>19</option>
                                <option <?php if ($sub['subHourEnd'] == 20){ echo 'selected';}?>>20</option>
                                <option <?php if ($sub['subHourEnd'] == 21){ echo 'selected';}?>>21</option>
                                <option <?php if ($sub['subHourEnd'] == 22){ echo 'selected';}?>>22</option>
                                <option <?php if ($sub['subHourEnd'] == 23){ echo 'selected';}?>>23</option>
                                <option <?php if ($sub['subHourEnd'] == 24){ echo 'selected'; }?>>24</option>
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
                            <input type="submit" name="updateSub" class="option"value="MAJ">
                          </td>
                          <td>
                            <input type="hidden" name="idSub" value="<?php echo $sub['idSub']; ?>">
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
          Ajouter un abonnement
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <table class="table table-hover table-dark">
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
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                                <option>16</option>
                                <option>17</option>
                                <option>18</option>
                                <option>19</option>
                                <option>20</option>
                                <option>21</option>
                                <option>22</option>
                                <option>23</option>
                                <option>24</option>
                              </select>
                            </div>
                          </td>
                          <td>
                             <div class="form-group">
                              <select class="form-control-sm" name="end">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                                <option>16</option>
                                <option>17</option>
                                <option>18</option>
                                <option>19</option>
                                <option>20</option>
                                <option>21</option>
                                <option>22</option>
                                <option>23</option>
                                <option>24</option>
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
                            <input type="submit" name="addSub" class="option"value="Ajouter !">
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


