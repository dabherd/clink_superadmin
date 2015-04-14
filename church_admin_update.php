<?php
// Database Connection 
require_once('_lib/connection.class.php');

// Validating Passed Entries
if (isset($_GET['id'], $_GET['username'], $_GET['first'], $_GET['last'], $_GET['mi'], $_GET['gender'], $_GET['addr'], $_GET['email'], $_GET['contact'])) {
	$uid = $_GET['id'];
	$uUsername = $_GET['username'];
	$uFirst = $_GET['first'];
	$uLast = $_GET['last'];
	$uMi = $_GET['mi'];
	$uGender = $_GET['gender'];
	$uAddr = $_GET['addr'];
	$uEmail = $_GET['email'];
	$uContact = $_GET['contact'];

// Filling Gender Radio Button
	$mChecked = null;
	$fChecked = null;

	if( $uGender == 'm') {
		$mChecked = 'checked';
		$fChecked = '';
	} elseif( $uGender == 'f') {
		$mChecked = '';
		$fChecked = 'checked';
	} else {
		$mChecked = '';
		$fChecked = '';
	}
} else {
	$uid = '';
	$uUsername = '';
	$uFirst = '';
	$uLast = '';
	$uMi = '';
	$uGender = '';
	$uAddr = '';
	$uEmail = '';
	$uContact = '';
	$mChecked = '';
	$fChecked = '';
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>	Congregation Link Update Admin </title>
	<link rel="stylesheet" href="_css/style.css">
</head>
<body>
	<div>
		<section id="body-container">
			<?php
		// Update Form
			$ua_username = null;
			$ua_firstname = null;
			$ua_lastname = null;
			$ua_mi = null;
			$ua_gender = null;
			$ua_addr = null;
			$ua_email = null;
			$ua_contact = null;

		// Retrieving from post
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				$ua_username = $_POST['username'];
				$ua_firstname = $_POST['user_firstname'];
				$ua_lastname = $_POST['user_lastname'];
				$ua_mi = $_POST['user_mi'];
				$ua_gender = $_POST['user_gender'];
				$ua_addr = $_POST['user_addr'];
				$ua_email = $_POST['user_email'];
				$ua_contact = $_POST['user_contact'];

				if (isset($ua_username, $ua_firstname, $ua_lastname, $ua_mi, $ua_gender, $ua_addr, $ua_email, $ua_contact) 
					&& !empty($ua_username) && !empty($ua_firstname) && !empty($ua_lastname) && !empty($ua_mi) && !empty($ua_gender) 
					&& !empty($ua_addr) && !empty($ua_email) && !empty($ua_contact)) {				
			// Generating Query Statement
				$db = Database::connection();
				$sql = "UPDATE users SET username =?, user_firstname =?, user_lastname =?, user_mi =?, user_gender =?, 
				user_addr =?, user_email =?, user_contact =? WHERE user_id =?";
				$query = $db->prepare($sql);
				if ($query->execute(array($ua_username, $ua_firstname, $ua_lastname, $ua_mi, $ua_gender, $ua_addr, $ua_email, $ua_contact, $uid))) {
					header('location: church_admin_update.php?success=1');
				} else {
					header('location: church_admin_update.php?success=0');
				}
			}			
			}
			?>
			<div class="form-fill">
				<form action="#successBox" method="POST">
					<label for="username"><span class="input-label">Username:</span>
						<input type="text" id="username" name="username" value='<?php echo $uUsername; ?>'>
					</label>
					<div id="name-container">
						<label for="user_firstname"><span class="input-label">First Name:</span>
							<input type="text" id="user_firstname" name="user_firstname" value='<?php echo $uFirst; ?>'>
						</label>
						<label for="user_lastname"><span class="input-label">Last Name:</span>
							<input type="text" id="user_lastname" name="user_lastname" value='<?php echo $uLast; ?>'>
						</label>
						<label for="user_mi"><span class="input-label">Middle Initial:</span>
							<input type="text" id="user_mi" name="user_mi" value='<?php echo $uMi; ?>'>
						</label>
					</div>
					<label for="user_addr"><span class="input-label">Address:</span>
						<input type="text" id="user_addr" name="user_addr" value='<?php echo $uAddr ?>'>
					</label>
					<label for="user_gender"><span class="input-label">Gender:</span>
						<input type="radio" name="user_gender" value="m" <?php echo $mChecked; ?> >Male
						<input type="radio" name="user_gender" value="f" <?php echo $fChecked; ?> >Female
					</label>
					<div id="contact-container">
						<label for="user_email"><span class="input-label">Email:</span>
							<input type="text" id="user_email" name="user_email" value='<?php echo $uEmail; ?>'>
						</label>
						<label for="user_contact"><span class="input-label">Contact:</span>
							<input type="text" id="user_contact" name="user_contact" value='<?php echo $uContact ?>'>
						</label>
					</div>
					<input type="submit" value="Update" class="button">
				</form>
			</div>
		</section>
	</div>
	<a href="#x" class="overlay" id="successBox"></a>
	<div id="modal-box-pop">
		<a class="close"href="#" onclick="close_window()"></a>
		<?php
		if (isset($_GET['success'])) {
			if ($_GET['success'] == 1) {
				echo '<h5 class="ok">Subscription Term Updated</h5>';
			} else {
				echo '<h5 class="error">Failed to Update  Subscription Term</h5>';
			}
		}						
		?>
	</div>
	<script>
		function close_window() {
			if (confirm("Close Window?")) {
				close();
			}
		}
	</script>
</body>
</html>