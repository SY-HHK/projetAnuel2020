<?php
session_start();
include("../include/config.php");

if (!isset($_SESSION["user"])) {
  header("../location: index.php");
  exit;
}

$getUserInfos = $pdo->prepare("SELECT * FROM USER WHERE userGuid = ?");
$getUserInfos->execute([$_SESSION["user"]]);
$nbUser = $getUserInfos->rowCount();
if ($nbUser == 0) {
  header("location: ../php/deconnexion.php");
  exit;
}
else {
  $userInfos = $getUserInfos->fetch();

  $getUserCity = $pdo->prepare("SELECT * FROM CITY WHERE idCity = ?");
  $getUserCity->execute([$userInfos["userIdCity"]]);
  $userCity = $getUserCity->fetch();

  $userInfos = array_merge($userInfos, $userCity);

  if (!empty($userInfos["idSubscription"])) {
    if (strtotime(date("Y-m-d")) < strtotime($userInfos['subEnd'])) {
      $getSubInfos = $pdo->prepare("SELECT subName FROM SUBSCRIPTION WHERE idSub = ?");
      $getSubInfos->execute([$userInfos["idSubscription"]]);
      $subInfos = $getSubInfos->fetch();

      $userInfos = array_merge($userInfos, $subInfos);
    }
  }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
</head>


<body>

<?php include('../include/new_header.php'); ?>

<main style="margin-bottom: 200px;">

<div class="container center">

  <div class="row">
      <div class="col s12">
        <ul class="tabs blue-grey darken-1">
          <li class="tab col s6"><a class="active white-text" href="#test1">Mes infos</a></li>
          <li class="tab col s6"><a class="white-text" href="#test2">Mes commandes</a></li>
        </ul>
      </div>
      <div id="test1" class="col s12">

    <div class="row">
      <form class="col s12">
        <div class="row">
          <div class="input-field col s12">
            <input id="last_name" type="text" class="validate" value="<?=$userInfos["userFirstName"]." ".$userInfos["userLastName"]?>">
            <label for="last_name">Prénom et nom :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="last_name" type="email" class="validate" value="<?=$userInfos["userEmail"]?>">
            <label for="last_name">Adresse email :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="last_name" type="text" class="validate" value="<?=$userInfos["userAddress"]?>">
            <label for="last_name">Adresse :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s5">
            <input id="last_name" type="text" class="validate" value="<?=$userInfos["cityName"]?>">
            <label for="last_name">Ville :</label>
          </div>
          <div class="input-field col s2">
            <input id="last_name" type="text" class="validate" value="<?=$userInfos["cityDepartement"]?>">
            <label for="last_name">Département :</label>
          </div>
          <div class="input-field col s5">
            <input id="last_name" type="text" class="validate" value="<?=$userInfos["cityRegion"]?>">
            <label for="last_name">Région :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input disabled id="last_name" type="text" class="validate" value="<?if (isset($userInfos['subName'])) echo $userInfos['subName'].' jusqu\'au '.date('d-m-Y',strtotime($userInfos['subEnd'])); else echo "aucun";?>">
            <label for="last_name">Abonnement :</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6">
            <input id="password" type="password" class="validate">
            <label for="password">Mot de passe :</label>
          </div>
          <div class="input-field col s6">
            <input id="password" type="password" class="validate">
            <label for="password">Confirmer mot de passe :</label>
          </div>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="action">Modifier
          <i class="material-icons right">send</i>
        </button>

      </form>
    </div>

      </div>



      <div id="test2" class="col s12">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </div>
  </div>


</div>



<div class="fixed-action-btn">
  <a class="btn-floating btn-large" href="../php/deconnexion.php">
    <i class="large material-icons">directions_walk</i>
  </a>
</div>



</main>

<?php include("../include/new_footer.php"); ?>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript">
  var el = document.querySelectorAll('.tabs')
  var instance = M.Tabs.init(el);

  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.fixed-action-btn');
    var instances = M.FloatingActionButton.init(elems);
  });
</script>
