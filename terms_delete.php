<?php
if ($_GET) {
	$delete_id = $_GET['id'];

	// Database Connection
	require_once('_lib/connection.class.php');
	$db = Database::connection();
	$sql = "UPDATE terms SET terms_status = 'i' WHERE terms_id =?";
	$query = $db->prepare($sql);
	if ($query->execute(array($delete_id))) {
		header('location: terms.php');
	}
} else {
	die('No Id Selected');
	header('location: terms.php');
}
?>