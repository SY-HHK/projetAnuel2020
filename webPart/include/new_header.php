<header>
  <nav class="blue-grey darken-3">
    <div class="nav-wrapper">
      <a href="index.php" class="brand-logo"><img src="images/logo.png" style="width: 90px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="subPrice.php">Abonnement</a></li>
        <?php
        if (isset($_SESSION["user"]) && !empty($_SESSION["user"]))
        { ?>
          <li><a href="profilUser.php">Profil</a></li>
      <?php  } else { ?>
          <li><a href="connexion.php">Se connecter</a></li>
      <?php  } ?>
      </ul>
    </div>
  </nav>
</header>
