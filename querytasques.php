<?php
require('class.connection.php');
require('config.php');

$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$project = (isset($_GET['project']))	? $_GET['project']		: '';
$subproj = (isset($_GET['subproj']))	? $_GET['subproj']		: '';

$nom	= (isset($_GET['titol']))		? $_GET['titol']		: '';
$descr	= (isset($_GET['descr']))		? $_GET['descr']		: '';
$estat	= (isset($_GET['estat']))		? $_GET['estat']		: '';
$prior	= (isset($_GET['prioritat']))	? $_GET['prioritat']	: '';
$dLimit	= (isset($_GET['datalimit']))	? $_GET['datalimit']	: '';
$dLimit = date2mysql2($dLimit);

$afegir		= (isset($_GET['afegirTasca']))		? $_GET['afegirTasca']		: '';
$esborrar	= (isset($_GET['esborrarTasca']))	? $_GET['esborrarTasca']	: '';
$editar		= (isset($_GET['editarTasca']))		? $_GET['editarTasca']		: '';

$id_tasca	= (isset($_GET['id_tasca']))		? $_GET['id_tasca']		: '';

/**
 * Afegir tasca
 *
 */

if ($afegir == 1) {
	$query = "SELECT MAX(ordre) FROM tasques";
	$max_ordre = $db->query($query);
	$max_ordre = $db->fetch_array($max_ordre);
	$max_ordre = $max_ordre['MAX(ordre)'];
	$ordre = $max_ordre + 1;
	
	if ($dLimit != '') {
		$query = "INSERT INTO tasques (id_projecte, id_subprojecte, nom, descripcio, prioritat, estat, data_limit, ordre)";
		$query .= "VALUES ('$project', '$subproj', '$nom', '$descr', '$prior', '$estat', '$dLimit', '$ordre')";
	} else {
		$query = "INSERT INTO tasques (id_projecte, id_subprojecte, nom, descripcio, prioritat, estat, data_limit, ordre)";
		$query .= "VALUES ('$project', '$subproj', '$nom', '$descr', '$prior', '$estat', NULL, '$ordre')";
	}
	$db->query($query);
} 



/**
 * Esborrar tasca
 *
 */

if ($esborrar == 1) {
	$query = "SELECT ordre FROM tasques WHERE id_tasca = ".$id_tasca;
	$ordre = $db->query($query);
	$ordre = $db->fetch_array($ordre);
	$ordre = $ordre['ordre'];
	
	$query = "DELETE FROM tasques WHERE id_tasca = ".$id_tasca;
	$db->query($query);
	
	$query = "UPDATE tasques SET ordre = ordre - 1 WHERE ordre > ".$ordre;
	$db->query($query);
}


$nomproj = $db->query("SELECT nom FROM projectes WHERE id_projecte = '$project'");
$nomproj = $db->fetch_array($nomproj);
$nomproj = $nomproj['nom'];

header('Location: index.php?p='.$nomproj);

?>
