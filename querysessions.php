<?php
require('class.connection.php');
require('config.php');

$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);








//INSERT MANUAL

if (isset($_GET['manual']) && $_GET['manual'] == 1) {
	$project	= (isset($_GET['project']))		? $_GET['project']		: '';
	$dataSes	= (isset($_GET['dataSessio']))	? $_GET['dataSessio']	: '';
	$horaSes	= (isset($_GET['horaSessio']))	? $_GET['horaSessio']	: '';
	$hores		= (isset($_GET['hores']))		? $_GET['hores']		: '';
	$mins		= (isset($_GET['minuts']))		? $_GET['minuts']			: '';
	$coment		= (isset($_GET['comentSessio']))		? $_GET['comentSessio']			: '';
	
	
	if ($mins == 0) {
		$durada = $hores.'h';
	} else {
		$durada = $hores.'h '.$mins.'m';
	}
	
	$data = split('/', $dataSes);
	$starthour = trim($data[2]).'-'.trim($data[1]).'-'.trim($data[0]);
	$starthour .= ' '.$horaSes;
	

	if ($coment != '') {
		$teComentari = 'S';
	} else {
		$teComentari = 'N';
	}

	
	$query = "INSERT into sessions_feina (id_projecte, data_hora_inici, durada, teComentari, comentari) ";
	$query .= "VALUES ('$project', '$starthour', '$durada', '$teComentari', '$coment')";
	
	$db->query($query);
} else {

	$project = (isset($_GET['project']))	? $_GET['project']		: '';
	
	$starthour = (isset($_GET['starthour']))	? $_GET['starthour']		: '';
	
	$hores = (isset($_GET['hores']))		? $_GET['hores']		: '';
	$mins  = (isset($_GET['mins']))			? $_GET['mins']			: '';
	$secs  = (isset($_GET['secs']))			? $_GET['secs']			: '';
	
	$com   = (isset($_GET['comentari']))	? $_GET['comentari']	: '';
	
	
	
	$durada = $hores.'h '.$mins.'m';
	
	if ($com != '') {
		$teComentari = 'S';
	} else {
		$teComentari = 'N';
	}
	
	
	$query = "INSERT into sessions_feina (id_projecte, data_hora_inici, durada, teComentari, comentari) ";
	$query .= "VALUES ('$project', '$starthour', '$durada', '$teComentari', '$com')";
	
	$db->query($query);
}




$nomproj = $db->query("SELECT nom FROM projectes WHERE id_projecte = '$project'");
$nomproj = $db->fetch_array($nomproj);
$nomproj = $nomproj['nom'];

$db->close();

header('Location: feina.php?p='.$nomproj);

?>