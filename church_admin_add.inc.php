<?php
// Database Connection
require_once('_lib/connection.class.php');
require_once('_utils/clink_functions.php');

// Initializing form variables
$ca_cid = null;
$ca_username = null;
$ca_firstname = null;
$ca_lastname = null;
$ca_mi = null;
$ca_password = null;
$ca_addr = null;
$ca_gender = null;
$ca_email = null;
$ca_contact = null;
$ca_name = null;
$ca_type = null;
$ca_status = null;

// Verifying post data
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Retrieving form post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$ca_cid = test_input($_POST['church_id']);
	$ca_username = test_input($_POST['username']);
	$ca_firstname = test_input($_POST['user_firstname']);
	$ca_lastname = test_input($_POST['user_lastname']);
	$ca_mi = test_input($_POST['user_mi']);
	$ca_password = test_input($_POST['password']);
	$ca_addr = test_input($_POST['user_addr']);
	$ca_gender = test_input($_POST['user_gender']);
	$ca_email = test_input($_POST['user_email']);
	$ca_contact = test_input($_POST['user_contact']);
	$ca_type = 'admin';
	$ca_status = 'a';
	
	// Establishing Database Connection
	$db = Database::connection();

	// Validating Existing Entry
	$sql = "SELECT * FROM users WHERE username =? AND password =? AND user_status = 'a' ";
	$query = $db->prepare($sql);
	$query->execute(array($ca_username, $ca_password));
	Database::disconnect();

	if ($query->fetch()) {
		header('location: church_admin.php?success=0');		
	} else {

		if (!empty($_POST['username']) && !empty($_POST['user_firstname']) && !empty($_POST['user_lastname']) 
			&& !empty($_POST['user_mi']) && !empty($_POST['password']) && !empty($_POST['user_email'])
			&& !empty($_POST['user_contact'])) {

						$sql = "INSERT INTO users (church_id, username, user_firstname, user_lastname, user_mi, password, user_addr,
							user_gender, user_email, user_contact, user_type, user_status) VALUES(?, ?, ?, ? ,? ,?, ?, ?, ?, ?, ?, ?)";
			$query = $db->prepare($sql);
			$query->execute(array($ca_cid, $ca_username, $ca_firstname, $ca_lastname, $ca_mi, 
				md5($ca_password), $ca_addr, $ca_gender, $ca_email, $ca_contact, $ca_type, $ca_status));
					// Closing Connection
			Database::disconnect();
			header('location: church_admin.php?success=1');
			} else {
				header('location: church_admin.php?success=0');
			}
	}
}

?>
<div id="form-container">
	<header id="form-header">
		<h3>Add New Administrator</h3>
	</header>
	<div class="form-fill">
		<form action="#successBox" method="POST">
			<label for="church_id"><span class="input-label">Church:</span>
				<div class="select-style">
					<select name="church_id" id="church_id">
						<?php 
						$db = Database::connection();
						$sql = "SELECT church_id, church_name FROM church WHERE church_status = 'a' ";
						foreach ($db->query($sql) as $rows) {
							
							echo '<option value='.$rows['church_id'].' '.$selected.'>'.$rows['church_name'].'</option>';
							
						}
						Database::disconnect();
						?>
					</select>
				</div>
			</label>
			<label for="username"><span class="input-label">Username:</span>
				<input type="text" id="username" name="username" placeholder="Username">
			</label>
			<div id="name-container">
				<label for="user_firstname"><span class="input-label">First Name:</span>
					<input type="text" id="user_firstname" name="user_firstname" placeholder="FirstName">
				</label>
				<label for="user_lastname"><span class="input-label">Last Name:</span>
					<input type="text" id="user_lastname" name="user_lastname" placeholder="LastName">
				</label>
				<label for="user_mi"><span class="input-label">Middle Initial:</span>
					<input type="text" id="user_mi" name="user_mi" placeholder="MiddleInitial">
				</label>
			</div>
			<label for="password"><span class="input-label">Password:</span>
				<input type="password" id="password" name="password" placeholder="Password">
			</label>
			<label for="user_addr"><span class="input-label">Address:</span>
				<input type="text" id="user_addr" name="user_addr" placeholder="Address">
			</label>
			<label for="user_gender"><span class="input-label">Gender:</span>
				<input type="radio" name="user_gender" value="m">Male
				<input type="radio" name="user_gender" value="f">Female
			</label>
			<div id="contact-container">
				<label for="user_email"><span class="input-label">Email:</span>
					<input type="text" id="user_email" name="user_email" placeholder="Email">
				</label>
				<label for="user_contact"><span class="input-label">Contact:</span>
					<input type="text" id="user_contact" name="user_contact" placeholder="Contact">
				</label>
			</div>
			<input type="submit" value="Create" class="button">
		</form>
	</div>
</div>