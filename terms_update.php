<?php
// Page Status
$current = "current";

// Defining Epoch Values
define('YEAR', 31536000);
define('DAY', 86400);

// Database Connection
require_once('_lib/connection.class.php');

// GET Variables
if ($_GET) {
	@$uId = $_GET['id'];
	@$uName = $_GET['name'];
	@$uAmt = $_GET['amt'];
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>	Congregation Link Subscription</title>
	<link rel="stylesheet" href="_css/style.css">
</head>
<body>
	<div>
		<section id="body-container">
			<?php
		// Update Form
			$ut_name = null;
			$ut_amt = null;
			$ut_year = null;
			$ut_day = null;
			$ut_duration = null;

		// Retrieving from post
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				$ut_name = $_POST['utname'];
				$ut_amt = $_POST['utamt'];
				
				// Epoch Value Calculation
				$ut_year = $_POST['utyear'] * YEAR;
				$ut_day = $_POST['utday'] * DAY;
				$ut_duration = $ut_year + $ut_day;

			// Establishing Data Conection
				$db = Database::connection();
				if (isset($ut_name) && isset($ut_amt) && !empty($ut_name) && !empty($ut_amt)) {
					
			// Generating Query Statement
					$sql = "UPDATE terms SET terms_name =?, terms_amount =?, terms_duration =? WHERE terms_id =?";
					$query = $db->prepare($sql);
					if ($query->execute(array($ut_name, $ut_amt, $ut_duration, $uId))) {
						header('location: terms_update.php?success=1');
					} else {
						header('location: terms_update.php?success=0');
					}
				}			
			}
			?>
			<div class="form-fill">
				<form action="#successBox" method="POST">
					<label for="utname"><span class="input-label">Term Name:</span>
						<input type="text" id="utname" name="utname" value="<?php echo $uName;?>" autofocus>
					</label>
					<label for="utamt"><span class="input-label">Term Amount:</span>
						<input type="text" id="utamt" name="utamt" value="<?php echo $uAmt?>">
					</label>
					<label for="utduration"><span class="input-label">Term Duration:</span>
						<input type="text" id="utyear" name="utyear" placeholder="Years">
						<input type="text" id="utday" name="utday" placeholder="Days">
					</label>
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