<?php
session_start();
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];

require_once('bdd.php');

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])) {


	$id = $_POST['Event'][0];

	$start = date('Y/m/d H:i:s', strtotime($_POST['Event'][1]));
	$end = date('Y/m/d H:i:s', strtotime($_POST['Event'][2]));

	$sql = "UPDATE events SET  start = '$start', end = '$end' WHERE id = $id ";

	$query = $bdd->prepare($sql);
	if ($query == false) {
		print_r($bdd->errorInfo());
		die('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
		print_r($query->errorInfo());
		die('Erreur execute');
	} else {
		die('OK');
	}
}
