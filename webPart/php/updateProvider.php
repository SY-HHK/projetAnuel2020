<?php
session_start();
require_once __DIR__ . "/Updater.php";

$update = new Updater($_POST, $_SESSION["provider"]);

if ($update->isAllSet() != "ok") {
    header("location: ../login/profilProvider.php?error=".$update->isAllSet());
    exit;
}

if ($update->isGoodPasswordProvider() == false) {
    header("location: ../login/profilProvider.php?error=wrongPassword");
    exit;
}

$worked = $update->updateProvider();

if ($worked == 0) {
    header("location: ../login/profilProvider.php?error=bddProvider");
    exit;
}
if ($worked == 1) {
    header("location: ../login/profilProvider.php?error=bddCity");
    exit;
}
else {
    header("location: ../login/profilProvider.php?success=updated");
    exit;
}

?>
