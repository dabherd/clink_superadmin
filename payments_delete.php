<?php
if ($_GET) {
	$delete_id = $_GET['id'];

	// Database Connection
	require_once('_lib/connection.class.php');
	$db = Database::connection();
	$sql = "UPDATE payment SET payment_status = 'i' WHERE payment_id =?";
	$query = $db->prepare($sql);
	if ($query->execute(array($delete_id))) {
		header('location: payments.php');
	}
} else {
	die('No Id Selected');
	header('location: payments.php');
}
?>