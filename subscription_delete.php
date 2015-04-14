<?php
if ($_GET) {
	$delete_id1 = $_GET['name'];
	$delete_id2 = $_GET['type'];

	// Database Connection
	require_once('_lib/connection.class.php');
	$db = Database::connection();
	$sql = "UPDATE subscription SET subscription_status = 'inactive' WHERE church_id =? AND terms_id =? ";
	$query = $db->prepare($sql);
	if ($query->execute(array($delete_id1, $delete_id2))) {
		header('location: subscription.php');
	}
} else {
	die('No Id Selected');
	header('location: subscription.php');
}
?>