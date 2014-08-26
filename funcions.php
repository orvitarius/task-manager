<?php

$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);


function obtenirIDprojecte($projecte, $db) {
	$query = $db->query("SELECT id_projecte FROM projectes WHERE nom = '$projecte'");
	$id_proj = $db->fetch_array($query);
	$id_projecte = $id_proj['id_projecte'];
	return $id_projecte;
}


function omplirArrayPrioritatsNom($db) {
	$arrayPrioritats = array();
	$prior = $db->query("SELECT * FROM prioritats");
	while($prioritat = $db->fetch_array($prior)) {
		$arrayPrioritatsNom[$prioritat['id_prioritat']] = $prioritat['nom'];
	}
	return $arrayPrioritatsNom;
}

function omplirArrayPrioritats($db) {
	$arrayPrioritatsNom = array();
	$prior = $db->query("SELECT * FROM prioritats");
	while($prioritat = $db->fetch_array($prior)) {
		$arrayPrioritats[$prioritat['id_prioritat']] = $prioritat['abreviacio'];
	}
	return $arrayPrioritats;
}

function omplirArrayEstats($db) {
	$arrayEstats = array();
	$estats = $db->query("SELECT * FROM estats");
	while($estat = $db->fetch_array($estats)) {
		$arrayEstats[$estat['id_estat']] = $estat['nom'];
	}
	return $arrayEstats;
}

function omplirArraySubprojects($id_projecte, $db) {
	$arraySubprojects = array();
	$subs = $db->query("SELECT * FROM subprojectes WHERE id_projecte = '$id_projecte'");
	while($sub = $db->fetch_array($subs)) {
		$arraySubprojects[$sub['id_subprojecte']] = $sub['nom'];
	}
	return $arraySubprojects;
}




/**
 * Tasques
 *
 */		

function dadesTasca($id_tasca, $db) {
	$query = "SELECT * FROM tasques WHERE id_tasca = ".$id_tasca;
	$dades = $db->query($query);
	$dades = $db->fetch_array($dades);
	return $dades;
}


function printTasques($id_projecte, $arrayPrioritats, $arrayEstats, $arraySubprojects, $tasca_activa, $db) {
	$tasques = "SELECT * FROM tasques WHERE id_projecte = ".$id_projecte." ORDER BY ordre ASC";
	$tasques = $db->query($tasques);
	while($tasca = $db->fetch_array($tasques)) {		
		printTasca($tasca, $arrayPrioritats, $arrayEstats, $arraySubprojects, $tasca_activa);
	}	
}


function printTasca($tasca, $arrayPrioritats, $arrayEstats, $arraySubprojects, $tasca_activa) {
	if ($tasca['data_limit'] != '') {
	    $avui = mktime();
	    $diesFinsLimit = strtotime($tasca['data_limit']) - $avui;
	    $diesFinsLimit = floor($diesFinsLimit/3600/24);
	    $dLimit = '<p class="tasca-data">'.$diesFinsLimit.'</p>';
	} else {
	    $dLimit = '';
	}
	
	if ($tasca['id_tasca'] == $tasca_activa) {
		$activa = 'seleccionada';
	} else {
	    $activa = '';
	}
	
	echo '<div draggable="true" id="'.$tasca['id_tasca'].'" class="tasca '.$arrayPrioritats[$tasca['prioritat']].' '.$arrayEstats[$tasca['estat']].' '.$arraySubprojects[$tasca['id_subprojecte']].' '.$activa.'" >';
	echo '<span class="tasca-titol" id="'.$tasca['id_tasca'].'">'.$tasca['nom'].'</span>';
	echo '<p class="tasca-descr">'.$tasca['descripcio'].'</p>';
	echo $dLimit;
	echo '</div>';
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
			



/**
 * Formulari
 *
 */
 
function selectSubprojectes($arraySubprojects, $sub_actiu) {
	foreach($arraySubprojects as $index=>$sub) {
	    if ($sub_actiu != '' && $sub_actiu == $index) {
	    	$selected = 'selected';
	    } else if ($sub_actiu == '' && $sub == 'General') {
	    	$selected = 'selected';
	    } else {
	    	$selected = '';
	    }		
	    echo '<option value="'.$index.'" '.$selected.'>'.$sub.'</option>';
	}
}


function selectEstats($arrayEstats, $est_actiu) {
	foreach($arrayEstats as $index=>$estat) {
		if ($est_actiu != '' && $est_actiu == $index) {
			$selected = 'selected';
		} else if ($est_actiu == '' && $estat == 'Activa') {
			$selected = 'selected';
		} else {
			$selected = '';
		}
		echo '<option value="'.$index.'" '.$selected.'>'.$estat.'</option>';
	}
}


function selectPrioritat($arrayPrioritatsNom, $pri_actiu) {
	foreach($arrayPrioritatsNom as $index=>$prior) {
		if ($pri_actiu != '' && $pri_actiu == $index) {
			$selected = "selected";
		} else if ($pri_actiu == '' && $prior == 'Normal') {
			$selected = "selected";
		} else {
			$selected = '';
		}
		echo '<option value="'.$index.'" '.$selected.'>'.$prior.'</option>';
	}
}



/**
 * Filtres
 *
 */
 
function filtresSubprojecte($arraySubprojects) {
	foreach($arraySubprojects as $index=>$subproject) {
		echo '<label class="filtrelabel filtres-subs">'.$subproject.'</label>';
		echo '<div class="checker checker-subs">';
		echo '<label for="sub-'.$index.'"></label>';
		echo '<input type="checkbox" name="sub-'.$index.'" value="1" checked="" id="sub-'.$index.'" />';
		echo '</div>';
	}
}

function filtresEstats($arrayEstats) {
	foreach($arrayEstats as $index=>$estat) {
		echo '<label class="filtrelabel filtres-est">'.$estat.'</label>';
		echo '<div class="checker checker-est">';
		echo '<label for="est-'.$index.'"></label>';
		echo '<input type="checkbox" name="est-'.$index.'" value="1" checked="" id="est-'.$index.'" />';
		echo '</div>';
	}
}

function filtresPrioritats($arrayPrioritatsNom) {
	foreach($arrayPrioritatsNom as $index=>$prior) {
	    echo '<label class="filtrelabel filtres-prior">'.$prior.'</label>';
	    echo '<div class="checker chekcer-prior">';
	    echo '<label for="pri-'.$index.'"></label>';
	    echo '<input type="checkbox" name="pri-'.$index.'" value="1" checked="" id="pri-'.$index.'" />';
	    echo '</div>';
	}
}



/**
 * Estadistiques projecte
 *
 */

function printEstadistiques($arraySubprojects, $id_projecte, $db) {
	foreach($arraySubprojects as $index=>$sub) {
		$vars = numeroTasquesSubrojecte($db, $index, $id_projecte);
		echo '<div class="estad">';
		echo '<label class="titol">'.$sub.'</label>';
		echo '<input class="tFetes" id="fetes-'.$index.'" value="'.$vars['acabades'].'" />';
		echo '<label class="nolabel">'.$vars['acabades'].' / '.$vars['total'].'</label>';
		echo '<input class="tTotal" id="total-'.$index.'" value="'.$vars['total'].'" />';
				
		echo '<div class="barra" id="barra-'.$index.'"><div class="end"></div><span class="percent">0%</span></div>';
				
		echo '</div>';
	}
}



/**
 * Print sessions feina
 *
 */

function printSessionsFeina($id_projecte, $db) {
	$query = "SELECT * FROM sessions_feina WHERE id_projecte = ".$id_projecte." ORDER BY data_hora_inici DESC";
							
	$sessions = $db->query($query);
	while($sessio = $db->fetch_array($sessions)) {
		$inici = sqldate2taula($sessio['data_hora_inici']);
		$durada = $sessio['durada'];
		$teComentari = $sessio['teComentari'];
		$comentari = $sessio['comentari'];
								
		if($teComentari != 'S') {
			$class = 'no-comen';
		} else {
			$class = '';
		}
							
		echo '<tr>';
		echo '<td class="data">'.$inici.'</td>';
		echo '<td class="temps">'.$durada.'</td>';
		echo '<td class="comen '.$class.'"><span class="coment-icon"></span><p>'.$comentari.'</p></td>';
		echo '</tr>';
	}						
}








/**
 * SETUP - TASQUES (index.php)
 *
 */

// PROJECTE ACTIU
$projecte = (isset($_GET['p'])) ? $_GET['p'] : 'Reptext';
$id_projecte = obtenirIDprojecte($projecte, $db);

$arrayPrioritats	= omplirArrayPrioritats($db);
$arrayPrioritatsNom	= omplirArrayPrioritatsNom($db);
$arrayEstats 		= omplirArrayEstats($db);
$arraySubprojects	= omplirArraySubprojects($id_projecte, $db);
	

// TASCA ACTIVA	
$tascaActiva = (isset($_GET['tasca'])) ? $_GET['tasca'] : '';
	
if($tascaActiva != '') {
	$dades = dadesTasca($tascaActiva, $db);
	$tActivaNom = $dades['nom'];
	$tActivaSub = $dades['id_subprojecte'];
	$tActivaDes = $dades['descripcio'];
	$tActivaPri = $dades['prioritat'];
	$tActivaEst = $dades['estat'];
	$tActivaDLi = $dades['data_limit'];
	if ($tActivaDLi != '') {
		$tActivaDLi = mysqldate2regular2($tActivaDLi);
	}
	$subT= $dades['id_subprojecte'];
} else {
	$tActivaNom = '';
	$tActivaDes = '';
	$tActivaDLi = '';
}	




/**
 * SETUP - PROJECTE (projecte.php)
 *
 */

// PROJECTE ACTIU
$projecte = (isset($_GET['p'])) ? $_GET['p'] : 'Reptext';
$id_projecte = obtenirIDprojecte($projecte, $db);

$arraySubprojects = omplirArraySubprojects($id_projecte, $db);

// DURADA SESSIONS FEINA
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
$horesTotals = $hores;

// DATES PROJECTE				
$query = "SELECT data_limit, YEARWEEK(data_limit), data_entrada FROM projectes WHERE id_projecte = ".$id_projecte;
$q = $db->query($query);
$dates = $db->fetch_array($q);

$dLimit			= $dates['data_limit'];
$setmanaLimit	= $dates['YEARWEEK(data_limit)'];
$dEntrada		= $dates['data_entrada'];
			
			
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












$db->close();

?>