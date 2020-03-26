<header>
  <nav class="blue-grey darken-3">
    <div class="nav-wrapper">
      <a href="/projetAnuel2020/webPart/index.php" class="brand-logo"><img src="/projetAnuel2020/webPart/images/logo.png" style="width: 90px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="/projetAnuel2020/webPart/shop/catalog.php">Services</a></li>
        <li><a href="/projetAnuel2020/webPart/sub/subPrice.php">Abonnement</a></li>
        <?php
        if (isset($_SESSION["user"]) && !empty($_SESSION["user"]))
        { ?>
          <li><a href="/projetAnuel2020/webPart/login/profilUser.php">Profil</a></li>
      <?php  } else { ?>
          <li><a href="/projetAnuel2020/webPart/login/connexion.php">Se connecter</a></li>
      <?php  } ?>
      </ul>
    </div>
  </nav>
</header>
