<?php
// Database Connection
require_once('_lib/connection.class.php');

// Page Status
$current = "current";

// Initializing form variables
$p_subscription = null;
$p_amount = null;
$p_date = null;
$p_uid = null;
$p_type = null;
$p_church = null;

// Verifying post data
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Retrieving form post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$p_subscription = test_input($_POST['psubs']);
	$p_amount = test_input($_POST['pamt']);

	// Setting the current time
	$p_date = time();

	$p_first = test_input($_POST['pfirst']);
	$p_last = test_input($_POST['plast']);
	$p_middle = test_input($_POST['pmiddle']);
	$p_type = test_input($_POST['ptype']);
	$p_church = test_input($_POST['pchurch']);
	$p_status = test_input($_POST['pstatus']);

	// Establishing Database Connection 
	$db = Database::connection();
	if (!empty($_POST['psubs']) && !empty($_POST['pamt']) && !empty($_POST['pfirst']) && !empty($_POST['plast']) && !empty($_POST['pmiddle']) && !empty($_POST['ptype']) && !empty($_POST['pchurch'])) {
		// Generating Query Statement
		$sql = "INSERT INTO payment(payment_subscription, payment_amount, payment_date, payer_firstname, payer_lastname, payer_middlename, payment_type, payment_church, payment_status) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$query = $db->prepare($sql);
		$query->execute(array($p_subscription, $p_amount, $p_date, $p_first, $p_last, $p_middle, $p_type, $p_church, $p_status));

	// Qquery Provided, Closing Connection
		Database::disconnect();
		header('location: payments.php?success=1');
	} else {
		header('location: payments.php?success=0');
	}
}
?>
<div id="form-container">
	<header id="form-header">
		<h3>Add New Payments</h3>
	</header>
	<div class="form-fill">
		<form action="#successBox" method="POST">
			<label for=""><span class="input-label">Payer Name:</span></label>
			<div id="name-container">
				<label for="pfirst"><span class="input-label">First:</span>
					<input type="text" id="pfirst" name="pfirst" placeholder="First">
				</label>
				<label for="plast"><span class="input-label">Last:</span>
					<input type="text" id="plast" name="plast" placeholder="Last">
				</label>
				<label for="pmiddle"><span class="input-label">Middle:</span>
					<input type="text" id="pmiddle" name="pmiddle" placeholder="Middle">
				</label>
			</div>
			<label for="psubs"><span class="input-label">Subscription:</span>
				<div class="select-style">
					<select name="psubs" id="psubs">
						<option value=""></option>
						<?php
						// Fetching Select Options from terms

						$db = Database::connection();
						$sql = "SELECT * FROM terms WHERE terms_status = 'a' ";
						foreach ($db->query($sql) as $rows) {
							echo '<option value='.$rows['terms_id'].'>'.$rows['terms_name'].'</option>';
						}
						?>
					</select>
				</div>
			</label>
			<label for="pamt"><span class="input-label">Amount:</span>
				<input type="text" id="pamt" name="pamt" placeholder="Payment Amount">
			</label>
			<label for="pchurch"><span class="input-label">Church</span>
				<div class="select-style">
					<select name="pchurch" id="pchurch">
						<option value=""></option>
						<?php
						// Fetching Select Options from churches

						$db = Database::connection();
						$sql = "SELECT * FROM church WHERE church_status = 'i'";
						Database::disconnect();
						foreach ($db->query($sql) as $rows) {
							echo '<option value='.$rows['church_id'].'>'.$rows['church_name'].'</option>';
						}
						?>
					</select>
				</div>
			</label>
			<input type="hidden" name="ptype" value="1">
			<input type="hidden" value="p" name="pstatus" >			
			<input type="submit" value="Create" class="button">
		</form>
	</div>
</div>
