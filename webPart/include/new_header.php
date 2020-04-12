<header>
  <nav class="blue-grey darken-3">
    <div class="nav-wrapper">
      <a href="/projetAnuel2020/webPart/index.php" class="brand-logo"><img src="/projetAnuel2020/webPart/images/logo.png" style="width: 90px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">

        <li><a href="/projetAnuel2020/webPart/shop/catalog.php"><?php echo $lang['services'];?></a></li>
        <li><a href="/projetAnuel2020/webPart/sub/subPrice.php"><?php echo $lang['sub'];?></a></li>
        <?php
        if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) { ?>
          <li><a href="/projetAnuel2020/webPart/login/profilUser.php"><?php echo $lang['profil'];?></a></li>
      <?php  } else { ?>
          <li><a href="/projetAnuel2020/webPart/login/connexion.php"><?php echo $lang['logIn'];?></a></li>
      <?php  } ?>
        <li class="langSelect">
          <div>
          <select onChange="location.href='/projetAnuel2020/webPart/index.php?lang='+this.options[this.selectedIndex].value;">
              <option value="fr" <?php if (isset($_COOKIE['lang']) && $_COOKIE['lang'] == 'fr') echo 'selected';   ?>>FR</option>
              <option value="en" <?php if (isset($_COOKIE['lang']) && $_COOKIE['lang'] == 'en') echo 'selected';   ?>>EN</option>
          </select>

        </div>
      </li>


      </ul>
    </div>
  </nav>
</header>
