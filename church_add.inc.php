<?php
// Database Connection
require_once('_lib/connection.class.php');
require_once('_utils/clink_functions.php');

// Initializing form variables
$c_name = null;
$c_addr = null;
$c_contact = null;
$c_parish = null;
$c_priest = null;
$c_patron = null;

// Verifying post data
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Retrieving form post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$c_name = test_input($_POST['cname']);
	$c_addr = test_input($_POST['caddr']);
	$c_contact = test_input($_POST['ccontact']);
	$c_parish = test_input($_POST['cparish']);
	$c_priest = test_input($_POST['cpriest']);
	$c_patron = test_input($_POST['cpatron']);
	$c_status = 'a';
	
	// Establishing Database Connection
	$db = Database::connection();

	// Generating Query Statement
	$sql = "SELECT * FROM church WHERE church_name =? AND church_addr =? AND church_status = 'a' ";
	$query = $db->prepare($sql);
	$query->execute(array($c_name, $c_addr));

	// Query Provided, Closing Connection
	Database::disconnect();
	if ($query->fetch()) {
		header('location: church.php?success=0');
	} else {

		// New Connection 
		$db = Database::connection();
		if (!empty($_POST['cname']) && !empty($_POST['caddr']) && !empty($_POST['ccontact']) && !empty($_POST['cparish']) && !empty($_POST['cpriest']) && !empty($_POST['cpatron'])) {
			$sql = "INSERT INTO church(church_name, church_addr, church_contact, church_Parish, church_ppriest, church_Patron, church_status) VALUES(?, ?, ?, ? ,? ,?, ?)";
			$query = $db->prepare($sql);
			$query->execute(array($c_name, $c_addr, $c_contact, $c_parish, $c_priest, $c_patron, $c_status));

		// Closing Connection
			Database::disconnect();
			logAction('Paul', 'ChurchAdded');
			header('location: church.php?success=1');
		} else {
			header('location: church.php?success=0');
		}
	}
}
?>
<div id="form-container">
	<header id="form-header">
		<h3>Add New Church</h3>
	</header>
	<div class="form-fill">
		<form action="#successBox" method="POST">
			<label for="cname"><span class="input-label">Church Name:</span>
				<input type="text" id="cname" name="cname" placeholder="Church Name">
			</label>
			<label for="caddr"><span class="input-label">Church Address:</span>
				<input type="text" id="caddr" name="caddr" placeholder="Church Address">
			</label>
			<label for="ccontact"><span class="input-label">Church Contact:</span>
				<input type="text" id="ccontact" name="ccontact" placeholder="Church Contact">
			</label>
			<label for="cparish"><span class="input-label">Church Parish:</span>
				<input type="text" id="cparish" name="cparish" placeholder="Church Parish">
			</label>
			<label for="cpriest"><span class="input-label">Church Priest:</span>
				<input type="text" id="cpriest" name="cpriest" placeholder="Church Priest">
			</label>
			<label for="cpatron"><span class="input-label">Church Patron:</span>
				<input type="text" id="cpatron" name="cpatron" placeholder="Church Patron">
			</label>
			<input type="submit" value="Create" class="button">
		</form>
	</div>
</div>
