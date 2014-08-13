<?php

require('class.connection.php');
require('config.php');

$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$drag = $_GET['drag'];
$drop = $_GET['drop'];

function ordre($idtasca, $db) {
	$query = "SELECT ordre FROM tasques WHERE id_tasca = ".$idtasca;
	$ordre = $db->query($query);
	$ordre = $db->fetch_array($ordre);
	$ordre = $ordre['ordre'];
	return $ordre;
}

$ordre_drag = ordre($drag, $db);
$ordre_drop = ordre($drop, $db);

echo 'drag:'.$ordre_drag;
echo 'drop:'.$ordre_drop;

//Recolocar
$queryPosicioDrag = "UPDATE tasques SET ordre = ".$ordre_drop." WHERE id_tasca = ".$drag;
echo $queryPosicioDrag;
echo '<br>';
$queryPujarPosicions = "UPDATE tasques SET ordre = ordre + 1 WHERE ordre >= '$ordre_drop' AND ordre < '$ordre_drag'";
echo $queryPujarPosicions;
echo '<br>';
$queryBaixarPosicions = "UPDATE tasques SET ordre = ordre - 1 WHERE ordre > '$ordre_drag' AND ordre <= '$ordre_drop'";
echo $queryBaixarPosicions;
echo '<br>';


if ($ordre_drag > $ordre_drop) {
	$db->query($queryPosicioDrag);
	$db->query($queryPujarPosicions);
	$db->query($queryPosicioDrag);
} else {
	$db->query($queryPosicioDrag);
	$db->query($queryBaixarPosicions);
	$db->query($queryPosicioDrag);
}
$db->close();

?>