<?php
// Database Connection
require_once('_lib/connection.class.php');
require_once '_utils/clink_functions.php';
// Defining Epoch Values
define('YEAR', 31536000);
define('DAY', 86400);
// Initializing form variables
$t_name = null;
$t_amt = null;
$t_duration = null;
$t_status = 'a';

// Verifying post data
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Retrieving form post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$t_name = test_input($_POST['tname']);
	$t_amt = test_input($_POST['tamt']);

	// Epoch Value Calculation
	$t_year = test_input($_POST['tyear']) * YEAR;
	$t_day = test_input($_POST['tday']) * DAY;
	$t_duration = $t_year + $t_day;

	// Establishing Database Connection
	$db = Database::connection();

	// Generating Query Statement
	$sql = "SELECT * FROM terms WHERE terms_name =? AND terms_status = 'a'";
	$query = $db->prepare($sql);
	$query->execute(array($t_name));

	// Query Provided, Closing Connection
	Database::disconnect();
	if ($query->fetch()) {
		header('location: terms.php?success=0');
	} else {

		// New Connection 
		$db = Database::connection();
		if (isset($t_name) && isset($t_amt) && !empty($t_name) && !empty($t_amt)) {
			$sql = "INSERT INTO terms(terms_name, terms_amount, terms_duration, terms_status) VALUES(?, ?, ?, ?)";
			$query = $db->prepare($sql);
			$query->execute(array($t_name, $t_amt, $t_duration, $t_status));
			logAction('Paul','Added');
		// Closing Connection
			Database::disconnect();

			header('location: terms.php?success=1');	
		} else {
			header('location: terms.php?success=0');
		}		
	}
}
?>

<div id="form-container">
	<header id="form-header">
		<h3>Add New Term</h3>
	</header>
	<div class="form-fill">
		<form action="#successBox" method="POST">
			<label for="tname"><span class="input-label">Term Name:</span>
				<input type="text" id="tname" name="tname" placeholder="Term Name" autofocus>
			</label>
			<label for="tamt"><span class="input-label">Term Amount:</span>
				<input type="text" id="tamt" name="tamt" placeholder="Term Amount">
			</label>
			<label for="tduration"><span class="input-label">Term Duration:</span>
				<input type="text" id="tyear" name="tyear" placeholder="Years">
				<input type="text" id="tday" name="tday" placeholder="Days">
			</label>
			<input type="submit" value="Create" class="button">
		</form>
	</div>
</div>

