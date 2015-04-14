<?php
if ($_GET) {
	$delete_id = $_GET['id'];
	// Database Connection
	require_once('_lib/connection.class.php');
	$db = Database::connection();
	$sql = "UPDATE church SET church_status = 'i' WHERE church_id =?";
	$query = $db->prepare($sql);
	if($query->execute(array($delete_id))) {
		header('location: church.php');
	} else {
		die('No Id Selected');
		header('location: church.php');
	}
}
?>