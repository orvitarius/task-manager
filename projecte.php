<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8" />
	
	<meta name="viewport" content="width=device-width" />
	<link rel="shortcut icon" href="images/favicon.png" />
	<title>Task Manager</title>
	
	
	<!-- JQUERY -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
	
	
	<link rel="stylesheet" href="css/reset.css" />
	<link rel="stylesheet" href="css/inici.css" />
	<link rel="stylesheet" href="css/feina.css" />
	<link rel="stylesheet" href="css/projecte.css" />
	<link rel="stylesheet" href="css/datepicker.css" />
	
	
	
</head>

<body>

	<?php require('class.connection.php'); ?>
	<?php require('config.php'); ?>
	<?php require('funcions.php'); ?>

	<?php $db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME); ?>
	
	<!-- MENU SUPERIOR -->
	
	<?php require_once('menu-superior.php'); ?>	
	
	<section class="feina-contingut projecte-contingut">
	
		<section class="feina-sub sub1">
			<h2 class="feina-sub-titol"><?php echo $projecte; ?><b>Fitxa del projecte</b></h2>
			
			<div class="bloc">
				<div class="dadaproject" id="dataInici">
					<label class="titol">Data inici</label>
					<span><?php echo mysqldate2regular($dEntrada); ?></span>
					<label class="dies">Fa <?php echo $diesDesdeInici; ?> dies</label>
				</div>
				
				<div class="percentatgeTemps"><div class="end"></div><span class="percent">0%</span></div>
				
				<div class="dadaproject" id="dataLimit">
					<label class="titol">Data límit</label>
					<span><?php echo mysqldate2regular($dLimit); ?></span>
					<label class="dies">Falten <?php echo $diesFinsLimit; ?> dies</label>
				</div>
				
				<div class="dadesHores">
					<label>Hores de feina</label>
					<span><?php echo $horesTotals; ?>
				</div>
			
				<div class="dadesHores projeccio">
					<label>Projecció hores</label>
					<span><?php echo round($projeccioHores,2); ?>
				</div>
				
				<div class="dadesHores projeccio">
					<label>Projecció dies</label>
					<span><?php echo ceil($projeccioDies); ?>
				</div>
			</div>
			
			
			<div class="estadistiques">
				
				<?php printEstadistiques($arraySubprojects, $id_projecte, $db); ?>
			
				<div class="estad total">
					<label class="titol">Total</label>
					<div class="barra" id="barra-total"><div class="end"></div><span class="percent">0%</span></div>
				</div>
			</div>
		</section>
	</section>
	
	
	<script src="index.js"></script>
	<script src="projecte.js"></script>

	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</body>

</html>