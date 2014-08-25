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

	<?php
	$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	$projecte = (isset($_GET['p'])) ? $_GET['p'] : 'Reptext';
	
	$query = $db->query("SELECT id_projecte FROM projectes WHERE nom = '$projecte'");
	$id_proj = $db->fetch_array($query);
	$id_projecte = $id_proj['id_projecte'];
	
	$arraySubprojects = array();
	$subs = $db->query("SELECT * FROM subprojectes WHERE id_projecte = '$id_projecte'");
	while($sub = $db->fetch_array($subs)) {
		$arraySubprojects[$sub['id_subprojecte']] = $sub['nom'];
	}

	function numeroTasquesSubrojecte($db, $id_sub, $id_projecte) {
		$query = "SELECT * FROM tasques WHERE id_projecte = ".$id_projecte." AND id_subprojecte = ".$id_sub;
		$query = $db->query($query);
		$num = $db->num_rows($query);
		$query = "SELECT * FROM tasques WHERE id_projecte = ".$id_projecte." AND id_subprojecte = ".$id_sub." AND estat = 4";
		$query = $db->query($query);
		$num2 = $db->num_rows($query);
		
		$vars = array( 'total' => $num, 'acabades' => $num2);
		return $vars;
	}

	function numeroTasquesProjecte($db, $id_projecte) {
		$query = "SELECT * FROM tasques WHERE id_projecte = ".$id_projecte;
		$query = $db->query($query);
		$num = $db->num_rows($query);
		$query = "SELECT * FROM tasques WHERE id_projecte = ".$id_projecte." AND estat = 4";
		$query = $db->query($query);
		$num2 = $db->num_rows($query);
		
		$vars = array( 'total' => $num, 'acabades' => $num2);
		return $vars;
	}

	?>
	
	<!-- MENU SUPERIOR -->
	
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
	</div>
	
	
	
	<section class="feina-contingut projecte-contingut">
	
		<section class="feina-sub sub1">
			<h2 class="feina-sub-titol"><?php echo $projecte; ?><b>Fitxa del projecte</b></h2>
			
			
			
			<div class="bloc">
			<?php
			
			$query = "SELECT durada FROM sessions_feina WHERE id_projecte = ".$id_projecte;
			$q = $db->query($query);
			$h = 0;
			$m = 0;
			while($ses = $db->fetch_array($q)) {
				$dur = $ses['durada'];
				$dus = split('h', $dur);
				$h += $dus[0]*60;
				$mins = split('m', $dus[1]);
				$m += $mins[0];
			}
			$hores = round(($h+$m)/60, 2);
			$horesTotals = round(($h+$m)/60, 2);
			
			
			$query = "SELECT data_limit, YEARWEEK(data_limit), data_entrada FROM projectes WHERE id_projecte = ".$id_projecte;
			$q = $db->query($query);
			$dates = $db->fetch_array($q);
			$dLimit = $dates['data_limit'];
			$setmanaLimit = $dates['YEARWEEK(data_limit)'];
			$dEntrada = $dates['data_entrada'];
			
			
			$varsTotal = numeroTasquesProjecte($db, $id_projecte);
			$percentatge = round($varsTotal['acabades'] / $varsTotal['total'] * 100, 1);
			$percentatgeRestant = 100 - $percentatge;
			$projeccioHores = $percentatgeRestant * $horesTotals / $percentatge;
			
			$diesDesdeInici = 0;
			$diesFinsLimit = 0;
			$avui = mktime();

			$diesFinsLimit = strtotime($dLimit) - $avui;
			$diesFinsLimit = floor($diesFinsLimit/3600/24);
			
			$diesDesdeInici = $avui - strtotime($dEntrada);
			$diesDesdeInici = floor($diesDesdeInici/3600/24);
			
			$projeccioDies = $diesDesdeInici * $percentatgeRestant / $percentatge;
			
			
			?>
			
			
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
			<?php foreach($arraySubprojects as $index=>$sub) {
				$vars = numeroTasquesSubrojecte($db, $index, $id_projecte);
				echo '<div class="estad">';
				echo '<label class="titol">'.$sub.'</label>';
				echo '<input class="tFetes" id="fetes-'.$index.'" value="'.$vars['acabades'].'" />';
				echo '<label class="nolabel">'.$vars['acabades'].' / '.$vars['total'].'</label>';
				echo '<input class="tTotal" id="total-'.$index.'" value="'.$vars['total'].'" />';
				
				echo '<div class="barra" id="barra-'.$index.'"><div class="end"></div><span class="percent">0%</span></div>';
				
				echo '</div>';
			}
			
			$varsTotal = numeroTasquesProjecte($db, $id_projecte);
			?>
			
				<div class="estad total">
					<label class="titol">Total</label>
					<!--<input id="fetes-total" value="<?php echo $varsTotal['acabades']; ?>" />
					<label class="nolabel">/</label>
					<input id="total-total" value="<?php echo $varsTotal['total']; ?>" />-->
					<div class="barra" id="barra-total"><div class="end"></div><span class="percent">0%</span></div>
				</div>
			</div>
		</section>
	</section>
	
	
	<script src="index.js"></script>
	<script src="clock.js"></script>
	<script src="feina.js"></script>
	<script src="projecte.js"></script>

	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</body>

</html>