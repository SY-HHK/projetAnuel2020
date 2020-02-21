<?php

session_start();
include ('include/config.php');

$query = $pdo->prepare('SELECT * FROM SUBSCRIPTION');
$query->execute();

$resultats = $query->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Souscrire à un abonnement</title>
    <?php include('css/linkCss.php');?>
    <link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/pricing.css">
    <meta charset="UTF-8">
</head>


<body>

<?php include('include/header.php'); ?>


<main>
	<div class="jumbotron">

		<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
			<h1 class="display-4">Les abonnements</h1>
		  <p class="lead">Home Services vous propose des abonnements qui vous permettent d'avoir de meilleurs accès à nos services. Ce qui peut inclure un service  24/24h selon les abonnements et plein d'autres avantages.</p>
		</div>

		<div class="container">

			<div class="card-deck mb-3 text-center">

				<?php foreach ($resultats as $sub) { ?>
					<div class="card mb-4 shadow-sm">
						<div class="card mb-4 shadow-sm">
							<div class="card-header">
								<h4 class="my-0 font-weight-normal">Abonnement <?php echo $sub['subName']; ?></h4>
							</div>
							<div class="card-body">
								<h1 class="card-title pricing-card-title"><?php echo $sub['subHour']; ?><small class="text-muted">h services/ mois</small></h1>
								<ul class="list-unstyled mt-3 mb-4">
									<li>Bénéficiez d'un accès privilégié en illimité <?php echo $sub['subDays']; ?>j/7 de <?php echo $sub['subHourStart']; ?>h à <?php echo $sub['subHourEnd']; ?>h.</li>
									<li>Demandes illimitées de renseignements</li>
									<li><?php echo $sub['subPrice']; ?>€ TTC/an</li>
									
								</ul>
								<button type="button" class="btn btn-lg btn-block btn-primary">Souscrire !</button>
							</div>
			    		</div>
			  		</div>
			 	<?php } ?>

			</div>

		</div>
	</div>
</main>


 
<?php include('include/footer.php'); ?>



</body>
</html>
