<?php

include('../include/config.php');

session_start();
if (!isset($_SESSION['admin'])){
header('location:../index.php');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Back office</title>
    <?php include('../css/linkCss.php');?>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
</head>


<body>

<?php
     include('include/headerBack.php');


if (isset($_POST['searchInput']) && !empty($_POST['searchInput'])) {

    $recherche = $_POST['searchInput'];

    $providerRequest = $pdo->prepare('SELECT * FROM PROVIDER WHERE
		providerFirstName LIKE ? OR
		providerLastName LIKE ? OR
		providerEmail LIKE ?');

    $providerRequest->execute([
        $recherche . '%',
        $recherche . '%',
        $recherche . '%']);

    $userRequest = $pdo->prepare('SELECT * FROM USER WHERE
		userFirstName LIKE ? OR
		userLastName LIKE ? OR
		userEmail LIKE ? AND userPrivilege != 10');

    $userRequest->execute([
        $recherche . '%',
        $recherche . '%',
        $recherche . '%']);

    $serviceRequest = $pdo->prepare('SELECT * FROM SERVICE WHERE
		serviceTitle LIKE ?');

    $serviceRequest->execute([
        $recherche . '%']);

    $subscriptionRequest = $pdo->prepare('SELECT * FROM SUBSCRIPTION WHERE
		subName LIKE ?');

    $subscriptionRequest->execute([
        $recherche . '%']);

    global $searchProvider;
    $searchProvider = $providerRequest->fetchAll();

    global $searchUser;
    $searchUser = $userRequest->fetchAll();

    global $searchService;
    $searchService =  $serviceRequest->fetchAll();

    global $searchSub;
    $searchSub = $subscriptionRequest->fetchAll();


}

?>
 <main>

     <div class="jumbotron table-responsive-xl">

        <div  class="align-content-center"><h1> Bienvenue sur le back-office de BRING.ME</h1></div>
         <hr class="my-4">

         <label>Faites vos recherches ici</label>

         <div  class="align-content-center">
             <form class="orm-inline d-flex justify-content-center" action="indexBack.php" method="POST">

                 <input id="searchInput" type="search" placeholder="Search" aria-label="Search" style="width: 505px; " name="searchInput">
                 <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>

             </form>
         </div>

        <div id="searchResult" class="align-content-center" style="width: 600px;">

            <?php if(isset($searchProvider) && !empty($searchProvider)){ ?>

                 <table class="table table-striped">
                     <thead>
                     <tr>
                         <th scope="col">Nos prestataires</th>
                         <th scope="col"> </th>
                         <th scope="col"> </th>
                         <th scope="col"> </th>
                     </tr>
                     </thead>
                     <tbody>

                     <?php foreach ($searchProvider as $provider){?>
                         <tr>
                             <td></td>
                             <td><a href="provider.php?providerSelected=<?php echo $provider['idProvider']; ?>" class="result"><?php echo $provider['providerFirstName']; ?></a></td>
                             <td><a href="provider.php?providerSelected=<?php echo $provider['idProvider']; ?>" class="result"><?php echo $provider['providerLastName']; ?></a></td>
                             <td><a href="provider.php?providerSelected=<?php echo $provider['idProvider']; ?>" class="result"><?php echo $provider['providerEmail']; ?></a></td>

                         </tr>

                     <?php }?>

                     </tbody>
                 </table>
            <?php } else if(isset($searchUser) && !empty($searchUser)){ ?>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Nos clients</th>
                        <th scope="col"> </th>
                        <th scope="col"> </th>
                        <th scope="col"> </th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($searchUser as $user){?>
                        <tr>
                            <td> </td>
                            <td <a href="user.php?userSelected=<?php echo $user['idUser']; ?>" class="result"> <?php echo $user['userFirstName']; ?><?php echo $user['userFirstName']; ?></a></td>
                            <td><a href="user.php?userSelected=<?php echo $user['idUser']; ?>" class="result"> <?php echo $user['userFirstName']; ?><?php echo $user['userLastName']; ?></a></td>
                            <td><a href="user.php?userSelected=<?php echo $user['idUser']; ?>" class="result"> <?php echo $user['userFirstName']; ?><?php echo $user['userEmail']; ?></a></td>
                        </tr>

                    <?php }?>

                    </tbody>
                </table>
            <?php } else if(isset($searchService) && !empty($searchService)){ ?>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Nos services</th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($searchService as $service){?>
                    <tr>
                        <td></td>
                        <td><a href="service.php?serviceSelected=<?php echo $service['idService']; ?>" class="result"> <?php echo $service['serviceTitle']; ?></a></td>
                    </tr>

                <?php }?>

                </tbody>
            </table>
            <?php } else if(isset($searchSub) && !empty($searchSub)){ ?>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Nos abonnements </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>

                </tr>
                </thead>
                <tbody>

                <?php foreach ($searchSub as $sub){?>
                    <tr>
                        <td></td>
                        <td><a href="subscription.php?subSelected=<?php echo $sub['idSub']; ?>" class="result"> <?php echo $sub['subName']; ?></a></td>
                    </tr>

                <?php }?>

                </tbody>
            </table>
            <?php }  ?>

        </div>


     </div>

 </main>

<div class="col-lg-4"></div>

<?php include('../include/footer.php'); ?>





</body>
</html>
