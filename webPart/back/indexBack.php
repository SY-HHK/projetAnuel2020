<?php


include('../include/config.php');

session_start();
// if (!isset($_SESSION['admin'])){
// header('location:../index.php');
//} //
?>

<!DOCTYPE html>
<html>
<head>
    <title>Back office</title>
    <?php include('../css/linkCss.php');?>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
</head>


<body>

<?php
     include('include/headerBack.php');
?>
 <main>

     <div class="container">

        <center><h1> Bienvenue sur le back-office de BRING.ME</h1></center>

      </div>

 </main>

<?php

	include('../include/footer.php');

?>





</body>
</html>