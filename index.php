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

	<?php
	$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	$projecte = (isset($_GET['p'])) ? $_GET['p'] : 'Reptext';
	
	$query = $db->query("SELECT id_projecte FROM projectes WHERE nom = '$projecte'");
	$id_proj = $db->fetch_array($query);
	$id_projecte = $id_proj['id_projecte'];
	
	
	$arrayPrioritats = array();
	$arrayPrioritatsNom = array();
	$arrayEstats = array();
	$arraySubprojects = array();
	
	$prior = $db->query("SELECT * FROM prioritats");
	while($prioritat = $db->fetch_array($prior)) {
		$arrayPrioritats[$prioritat['id_prioritat']] = $prioritat['abreviacio'];
		$arrayPrioritatsNom[$prioritat['id_prioritat']] = $prioritat['nom'];
	}
	
	$estats = $db->query("SELECT * FROM estats");
	while($estat = $db->fetch_array($estats)) {
		$arrayEstats[$estat['id_estat']] = $estat['nom'];
	}
	
	$subs = $db->query("SELECT * FROM subprojectes WHERE id_projecte = '$id_projecte'");
	while($sub = $db->fetch_array($subs)) {
		$arraySubprojects[$sub['id_subprojecte']] = $sub['nom'];
	}
	
	
	/**
	 * Tasca activa
	 *
	 */	
	
	$tascaActiva = (isset($_GET['tasca'])) ? $_GET['tasca'] : '';
	
	if($tascaActiva != '') {
		$query = "SELECT * FROM tasques WHERE id_tasca = ".$tascaActiva;
		$dades = $db->query($query);
		$dades = $db->fetch_array($dades);
		$nom = $dades['nom'];
		$subT = $dades['id_subprojecte'];
		$des = $dades['descripcio'];
		$pri = $dades['prioritat'];
		$est = $dades['estat'];
		$dli = $dades['data_limit'];
		if ($dli != '') {
			$dli = mysqldate2regular2($dli);
		}
		$subT= $dades['id_subprojecte'];
	} else {
		$nom = '';
		$des = '';
		$pri = '';
		$est = '';
		$subT = '';
		$dli = '';
		$subT = '';
	}


	
	
	?>

	
	<div class="menu-superior">
		<a class="titol-projecte" href="index.php?p=<?php echo $projecte; ?>"><?php echo $projecte; ?></a>
		
		<svg height="20" width="20" class="fletxa">
			<polyline fill="none" stroke="darkred" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
				points =	"0,0
							 8,12
							 16,0" />
		</svg>
		
		
		<ul class="selector" id="selector-projectes">
			<?php
			$query = $db->query("SELECT nom FROM projectes");
			while ($proj = $db->fetch_array($query)) {
				echo '<li><a href="index.php?p='.$proj['nom'].'">'.$proj['nom'].'</a></li>';
			}
			?>
		</ul>
		
		<a class="button afegir" id="nova-feina" href="feina.php?p=<?php echo $projecte; ?>">+</a>
	</div>
	
	
	<!-- IMPRIMIT TASQUES -->
	
	<section class="tasques <?php echo ($tascaActiva == '') ? 'feina-hidden' : '' ?>">
	
		<?php
		$tasques = "SELECT * FROM tasques WHERE id_projecte = ".$id_proj['id_projecte']." ORDER BY ordre ASC";
		$tasques = $db->query($tasques);
		while($tasca = $db->fetch_array($tasques)) {
			if ($tasca['id_tasca'] == $tascaActiva) {
				$activa = 'seleccionada';
			} else {
				$activa = '';
			}
			
			echo '<div draggable="true" id="'.$tasca['id_tasca'].'" class="tasca '.$arrayPrioritats[$tasca['prioritat']].' '.$arrayEstats[$tasca['estat']].' '.$arraySubprojects[$tasca['id_subprojecte']].' '.$activa.'" >';
			echo '<span class="tasca-titol" id="'.$tasca['id_tasca'].'">'.$tasca['nom'].'</span>';
			echo '<p class="tasca-descr">'.$tasca['descripcio'].'</p>';
			echo '</div>';
		}
		?>
	
	
	</section>
	
	
	
	<!-- FORMULARI -->
	
	<section class="feina <?php echo ($tascaActiva == '') ? 'hidden' : '' ?>">
	<div id="feina-sidebar">
	</div>
	<form id="tascaform" method="get" action="querytasques.php">
		<input style="display:none" name="project" value="<?php echo $id_proj['id_projecte']; ?>" />
		<input style="display:none" name="tascaAct" value="<?php echo $tascaActiva; ?>" />

	
		<input class="feina-titol" placeholder="Nom tasca" id="titol" name="titol" value="<?php echo $nom; ?>" />
	
		<textarea class="feina-descr" placeholder="Descripció" id="descr" name="descr" text="<?php echo $des; ?>"></textarea>
		
		<label>Subprojecte</label>
		<select id="feina-sub" name="subproj" value="<?php echo $subT; ?>">
			<?php foreach($arraySubprojects as $index=>$sub) {
				if ($subT != '' && $subT == $index) {
					$selected = 'selected';
				} else if ($subT == '' && $sub == 'General') {
					$selected = 'selected';
				} else {
					$selected = '';
				}
				
				echo '<option value="'.$index.'" '.$selected.'>'.$sub.'</option>';
			} ?>
		</select>
		
		<label>Estat</label>
		<select id="feina-estat" name="estat" value="<?php echo $est; ?>">
			<?php foreach($arrayEstats as $index=>$estat) {
				if ($est != '' && $est == $index) {
					$selected = 'selected';
				} else if ($est == '' && $estat == 'Activa') {
					$selected = 'selected';
				} else {
					$selected = '';
				}
				
				echo '<option value="'.$index.'" '.$selected.'>'.$estat.'</option>';
			} ?>
		</select>
		
		<label>Prioritat</label>
		<select id="feina-prioritat" name="prioritat">
			<?php foreach($arrayPrioritatsNom as $index=>$prior) {
				if ($pri != '' && $pri == $index) {
					$selected = "selected";
				} else if ($pri == '' && $prior == 'Normal') {
					$selected = "selected";
				} else {
					$selected = '';
				}
				
				echo '<option value="'.$index.'" '.$selected.'>'.$prior.'</option>';
			} ?>
		</select>
	
		<label class="floater">Data límit</label>
		<input type="text" class="datepicker" id="datalimit" name="datalimit" value="<?php echo $dli; ?>">
	
		
		<button class="buttonform one" name="afegirTasca"   value="1" title=""  id="buttonForm1" ></button>
		<button class="buttonform two-two" name="cancelar" value="1" title=""id="buttonForm2" ></button>
	
	</form>
	</section>
	
	
	<div id="paperera"></div>
	
	<!-- FILTRES -->
	
	<section class="filtres">
	
		<form id="filtres" method="get" action="index.php">
			
			<?php foreach($arraySubprojects as $index=>$subproject) {
				echo '<label class="filtrelabel filtres-subs">'.$subproject.'</label>';
				echo '<div class="checker checker-subs">';
				echo '<label for="sub-'.$index.'"></label>';
				echo '<input type="checkbox" name="sub-'.$index.'" value="1" checked="" id="sub-'.$index.'" />';
				echo '</div>';
			}
			?>
			
			<?php foreach($arrayEstats as $index=>$estat) {
				echo '<label class="filtrelabel filtres-est">'.$estat.'</label>';
				echo '<div class="checker checker-est">';
				echo '<label for="est-'.$index.'"></label>';
				echo '<input type="checkbox" name="est-'.$index.'" value="1" checked="" id="est-'.$index.'" />';
				echo '</div>';
			}
			?>
			
			<?php foreach($arrayPrioritatsNom as $index=>$prior) {
				echo '<label class="filtrelabel filtres-prior">'.$prior.'</label>';
				echo '<div class="checker chekcer-prior">';
				echo '<label for="pri-'.$index.'"></label>';
				echo '<input type="checkbox" name="pri-'.$index.'" value="1" checked="" id="pri-'.$index.'" />';
				echo '</div>';
			}
			?>
		</form>
	</section>
	
	
	
	
	
	<script src="index.js"></script>

	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</body>



</html>