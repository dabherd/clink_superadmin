<?php
// Page Status
$current = "current";

// Defining Epoch Values
define('YEAR', 31536000);
define('DAY', 86400);

// Database Connection
require_once('_lib/connection.class.php');
if ($_GET) {
	@$uChurch = $_GET['cid'];
	@$uTerms = $_GET['tid'];
	@$uPayment = $_GET['pid'];
	@$uStart = strtotime($_GET['start']);
	@$uEnd = strtotime($_GET['end']);
	@$uStatus = $_GET['status'];
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Subscription Update</title>
	<link rel="stylesheet" href="_css/style.css">
	<link rel="stylesheet" href="jquery-ui.css">
</head>
<body>
	<div>
		<section id="body-container">
			<?php
		// Update Form
			$up_start = null;
			$up_end = null;
			$up_status = null;
						
		// Retrieving from post
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				$up_start = strtotime($_POST['upstart']);
				$up_end = strtotime($_POST['upend']);
				$up_status = $_POST['upstatus'];
			// Establishing Data Conection
				$db = Database::connection();
				if (isset($up_start) && isset($up_end) && isset($up_status)
					&& !empty($up_start) && !empty($up_end) && !empty($up_status)) {
					
			// Generating Query Statement
					$sql = "UPDATE subscription SET subscription_start =?, subscription_end =?, subscription_status =? WHERE church_id =? AND terms_id =? AND payment_id =?";
				$query = $db->prepare($sql);
				if ($query->execute(array($up_start, $up_end, $up_status, $uChurch, $uTerms, $uPayment))) {
					header('location: subscription_update.php?success=1');
				} else {
					header('location: subscription_update.php?success=0&start='.$up_start.'&end='.$up_end.'&status='.$up_status.'');
				}
			}

		}
		// Fetching Select Options from status
		function selectedStatus($row_status) {
			global $uStatus;

			$selected = null;
			if ($row_status == $uStatus) {
				$selected = 'Selected';
			}else {
				$selected = '';
			}
			return $selected;
		}
		?>
		<div class="form-fill">
			<form action="#successBox" method="POST">			
				<label for="upstart"><span class="input-label">Subscription Start:</span>
					<input type="date" id="date" name="upstart" placeholder="Subscription Start" value="<?php echo strftime("%m/%d/%Y", $uStart);?>">
				</label>			
				<label for="upend"><span class="input-label">Subscription End:</span>
					<input type="date" id="date_end" name="upend"  value="<?php echo strftime("%m/%d/%Y",$uEnd);?>">
				</label>
				<label for="upstatus"><span class="input-label">Type:</span>
					<input type="radio"  name="upstatus" value="active" <?php echo $uStatus == 'a' ? 'checked' : ' ';?>>Active
					<input type="radio"  name="upstatus" value="inactive" <?php echo $uStatus == 'i' ? 'checked' : ' '; ?>>Inactive
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
			echo '<h5 class="ok">Subscription Updated</h5>';
		} else {
			echo '<h5 class="error">Failed to Update Subscription</h5>';
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
<script src="jquery.min.js"></script>
<script src="jquery-ui.js"></script>
<script>

$('#date').datepicker();
$('#date_end').datepicker();
</script>
</body>
</html>