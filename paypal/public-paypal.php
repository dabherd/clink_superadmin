<?php
/**
 * Example: Simple Payment
 * 
 * This example shows the simplest method of accepting a payment.
 */

require_once( '_lib/functions.php' );

$paypal = create_example_subscription();

?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<div class="container">
		<?php
// Database Connection
		require_once('connection.php');

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
	
			// $p_subscription = test_input($_POST['psubs']);
			// $p_amount = test_input($_POST['pamt']);
			// $p_date = time();
			// $p_uid = test_input($_POST['puid']);
			// $p_type = test_input($_POST['ptype']);
			// $p_church = test_input($_POST['pchurch']);

			$sub_array = array(
				'subscription' => test_input($_POST['psubs']),
				'amount' => test_input($_POST['pamt']),
				'amount' => test_input($_POST['pamt']),
				'date' => 'Month',
				'prayer' => test_input($_POST['ptype']),
				'type' => test_input($_POST['pchurch'])
				);			
		} else {
			$sub_array = array();
		}
		?>
		<header id="form-header">
			<h3>Add New Payments</h3>
		</header>
		<div class="form-fill">
			<form action="functions.php<?foreach ($sub_array as $key => $value) {
				echo $key.'='.$value.'&';
			}?>" method="POST">
			<label for="psubs"><span class="input-label">Subscription:</span>
				<div class="select-style">
					<select name="psubs" id="psubs">
						<option value=""></option>
						<?php

						// Fetching Select Options from terms
						$db = Database::connection();
						$sql = "SELECT * FROM terms WHERE terms_status = 'active' ";
						Database::disconnect();
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
			<label for="puid"><span class="input-label">Client Id:</span>
				<input type="text" id="puid" name="puid" placeholder="Payer Id">
			</label>
			<label for="pchurch"><span class="input-label">Church</span>
				<div class="select-style">
					<select name="pchurch" id="pchurch">
						<option value=""></option>
						<?php

						// Fetching Select Options from churches
						$db = Database::connection();
						$sql = "SELECT * FROM church WHERE church_status = 'active'";
						Database::disconnect();
						foreach ($db->query($sql) as $rows) {
							echo '<option value='.$rows['church_id'].'>'.$rows['church_name'].'</option>';
						}
						?>
					</select>
				</div>
			</label>
			<label for="ptype"><span class="input-label">Type:</span>
				<input type="radio" name="ptype" value="1">Subscription
				<input type="radio" name="ptype" value="2">Donation
			</label>			
			<?php $paypal->print_buy_button(); ?>
		</form>
	</div>
</div>
</body>
</html>
