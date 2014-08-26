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
	<link rel="stylesheet" href="css/datepicker.css" />
	
</head>

<body>

	<?php require('class.connection.php'); ?>
	<?php require('config.php'); ?>
	<?php require('funcions.php'); ?>

	<?php $db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME); ?>

	
	<?php require_once('menu-superior.php'); ?>
	
	
	<!-- IMPRIMIR TASQUES -->
	<section class="tasques <?php echo ($tascaActiva == '') ? 'feina-hidden' : '' ?>">
		<?php printTasques($id_projecte, $arrayPrioritats, $arrayEstats, $arraySubprojects, $tascaActiva, $db); ?>
	</section>
	
	
	<!-- FORMULARI -->
	<section class="feina <?php echo ($tascaActiva == '') ? 'hidden' : '' ?>">
		<div id="feina-sidebar"></div>
		<form id="tascaform" method="get" action="querytasques.php">
			<input style="display:none" name="project"  value="<?php echo $id_projecte; ?>" />
			<input style="display:none" name="tascaAct" value="<?php echo $tascaActiva; ?>" />
		
			<input class="feina-titol" placeholder="Nom tasca" id="titol" name="titol" value="<?php echo $tActivaNom; ?>" />
		
			<textarea class="feina-descr" placeholder="Descripció" id="descr" name="descr" text="<?php echo $tActivaDes; ?>"></textarea>
			
			<label>Subprojecte</label>
			<select id="feina-sub" name="subproj" value="<?php echo $tActivaSub; ?>">
				<?php selectSubprojectes($arraySubprojects, $tActivaSub); ?>
			</select>
			
			<label>Estat</label>
			<select id="feina-estat" name="estat" value="<?php echo $tActivaEst; ?>">
				<?php selectEstats($arrayEstats, $tActivaEst); ?>
			</select>
			
			<label>Prioritat</label>
			<select id="feina-prioritat" name="prioritat">
				<?php selectPrioritat($arrayPrioritatsNom, $tActivaPri); ?>
			</select>
		
			<label class="floater">Data límit</label>
			<input type="text" class="datepicker" id="datalimit" name="datalimit" value="<?php echo $tActivaDLi; ?>">
		
			<button class="buttonform one" name="afegirTasca"   value="1" title=""  id="buttonForm1" ></button>
			<button class="buttonform two-two" name="cancelar" value="1" title=""id="buttonForm2" ></button>
		</form>
	</section>
	
	
	<div id="paperera"></div>
	
	
	<!-- FILTRES -->
	<section class="filtres">	
		<form id="filtres" method="get" action="index.php">
			<?php filtresSubprojecte($arraySubprojects); ?>
			
			<?php filtresEstats($arrayEstats); ?>
			
			<?php filtresPrioritats($arrayPrioritatsNom); ?>
		</form>
	</section>
	
	
	<?php $db->close(); ?>
	
	<!-- JS -->	
	<script src="index.js"></script>

	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</body>
</html>