<?php 
if (isset($_GET['id'])) {
	require_once('_lib/connection.class.php');
	$user_id = $_GET['id'];

	$db = Database::connection();
	$sql = "UPDATE users SET user_status = 'i' WHERE user_id =?";
	$query = $db->prepare($sql);
	$query->execute(array($user_id));
	header('location: church_admin.php?delete=1');
} else {
	header('location: church_admin.php?delete=0');
}	
 ?>