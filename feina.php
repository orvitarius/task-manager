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
	<link rel="stylesheet" href="css/datepicker.css" />
	
</head>

<body>

	<?php require('class.connection.php'); ?>
	<?php require('config.php'); ?>
	<?php require('funcions.php'); ?>

	<?php
	$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	$avui = date('d / m / Y', mktime());
	$avuiSQL = date('Y-m-d H:s', mktime());
	?>
	
	<!-- MENU SUPERIOR -->
	
	<?php require_once('menu-superior.php'); ?>
		
	<section class="feina-contingut">
	
		<section class="feina-sub sub1">
		
			<h2 class="feina-sub-titol">Nova sessió de feina<b><?php echo $avui; ?></b></h2>
		
			<form id="nova-feina" method="get" action="querysessions.php">
			
				<input style="display:none" name="project" value="<?php echo $id_projecte; ?>" />
				<input style="display:none" name="starthour" value="" id="starthour" />
				
				<div class="time">
				<input class="time-h" id="hores" name="hores" value="00" />
				<label>:</label>
				<input class="time-m" id="mins" name="mins" value="00"/>
				<label>:</label>
				<input class="time-s" id="secs" name="secs" value="00"/></div>
				
			
				<div class="rellotge" id="rellotge1">
					
					<label class="hores-label">H</label>
					<div class="agulla hores"><div class="end"></div></div>
					<label class="minuts-label">M</label>
					<div class="agulla minuts"><div class="end"></div></div>
					<label class="segons-label">S</label>
					<div class="agulla segons"><div class="end"></div></div>
					
				</div>
				
				<input type="button" name="start" class="timer-button" id="start" value="" />
				<input type="button" name="stop" class="timer-button reset" id="stop" value="" />
								
				<textarea placeholder="Comentaris" name="comentari"></textarea>
				
				<button type="" class="boto-form" id="afegirSessio" ></button>
			</form>	
			
			<button id="novaSessioButton"></button>
		</section>
		
		<section class="feina-sub sub2">
			<h2 class="feina-sub-titol">Sessions de feina</h2>
			
			<div class="fixedtable">
				<div class="fixedheader">
				
				</div>
				<div class="scrollbody">
					<table id="sessions-table">
						<tbody>
							
							<?php printSessionsFeina($id_projecte, $db); ?>
								
						</tbody>
					</table>
				</div>
				<div class="total">
					<table>
					<tr><td class="data"></td><td class="temps"></td><td class="comen"><span id="commentsearch" class="coment-icon-blank"></span></td></tr>
					</table>
				</div>
			</div>
			
			<div class="popupcomment"><p></p></div>
		</section>
	
	</section>
	
	
	<div id="novaSessioDiv" class="invisible">
		<form id="novaSessioForm" method="get" action="querysessions.php">

			<input style="display:none" name="project" value="<?php echo $id_projecte; ?>" />
			<input style="display:none" name="manual" value="1" />
			
			<div class="dadaform">
			<label>Data sessió</label>
			<input id="data" name="dataSessio" class="datepicker" value="<?php echo $avui; ?>" />
			</div>
			
			<div class="dadaform">
			<label>Hora de la sessió</label>
			<input id="hora" name="horaSessio" value="09:00:00" />
			</div>
		
			<div class="dadaform durada">
			<label>Durada</label>
			<input id="hores" name="hores" value="1" />
			<label class="sublabel">h</label>
			<input id="minuts" name="minuts" value="00" />
			<label class="sublabel">m</label>
			</div>
			
			<textarea name="comentSessio" placeholder="Comentaris"></textarea>
		</form>
	</div>
	
	
	<script src="index.js"></script>
	<script src="clock.js"></script>
	<script src="feina.js"></script>
	
	
</body>

</html>