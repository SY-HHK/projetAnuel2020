<?php
session_start();
require_once __DIR__ . "/Updater.php";

$update = new Updater($_POST, $_SESSION["user"]);

if ($update->isAllSet() != "ok") {
    header("location: ../login/profilUser.php?error=".$update->isAllSet());
    exit;
}

if ($update->isGoodPasswordUser() == false) {
    header("location: ../login/profilUser.php?error=wrongPassword");
    exit;
}

$worked = $update->updateUser();

if ($worked == 0) {
    header("location: ../login/profilUser.php?error=bddProvider");
    exit;
}
if ($worked == 1) {
    header("location: ../login/profilUser.php?error=bddCity");
    exit;
}
else {
    header("location: ../login/profilUser.php?success=updated");
    exit;
}

?>
