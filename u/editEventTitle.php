<?php

require_once('bdd.php');

if (isset($_POST['delete']) && isset($_POST['id'])){
	
	
	$id = $_POST['id'];
	
	$sql = "DELETE FROM events WHERE id = $id";
	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$res = $query->execute();
	if ($res == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}
	
}
elseif (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['color']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['id'])){
	
	$id = $_POST['id'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$color = $_POST['color'];

	$newDateStart = date('Y-m-d h-m-s', strtotime($start));
	$newDateEnd = date('Y-m-d h-m-s', strtotime($end));
	
	$sql = "UPDATE events SET  title = '$title', description = '$description',start = '$newDateStart',end = '$newDateEnd', color = '$color' WHERE id = $id ";
	
	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}

}
header('Location: eventCalendar.php');

	
?>
