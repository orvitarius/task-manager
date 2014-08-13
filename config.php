<?php
/*
---------------------------------
Arxius de configuracions comunes
---------------------------------
*/

//include("class.connection.php");

// Variables base de dades

define("DB_HOST", "localhost");
define("DB_USER", "admin");
define("DB_PASS", "12345");
define("DB_NAME", "orvitarius");



// Format de la data MySQL --> dd/mm/aaaa

function mysqldate2regular($date) {
	$y = split('-', $date);
	$y = $y[0];
	if ($y == '0000') {
		$newDate = '-';
	} else {
		$newDate = date("d / m / Y", strtotime($date));
	}
	return $newDate;
}

function mysqldate2regular2($date) {
	$y = split('-', $date);
	$y = $y[0];
	if ($y == '0000') {
		$newDate = '-';
	} else {
		$newDate = date("d/m/Y", strtotime($date));
	}
	return $newDate;
}

function date2mysql($date) {
	$date = str_replace(" / ", "-", $date);
	$newDate = date("Y-m-d", strtotime($date));
	return  $newDate;
}

function date2mysql2($date) {
	if ($date != '') {
		$date = str_replace("/", "-", $date);
		$newDate = date("Y-m-d", strtotime($date));
	} else {
		$newDate = '';
	}
	
	return  $newDate;
}

// Convertir 0 a '-' per alguns camps de taula

function zero2null($camp) {
	if ($camp == 0) {
		$camp = '';
	}
	return $camp;
}




?>