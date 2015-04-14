<?php
// Page Status
$current = "current";

// Defining Epoch Values
define('YEAR', 31536000);
define('DAY', 86400);

// Database Connection
require_once('_lib/connection.class.php');
if ($_GET) {
	@$uId = $_GET['id'];
	@$uStype = $_GET['stype'];
	@$uAmt = $_GET['amt'];
	@$uDate = $_GET['date'];
	@$uPayer = $_GET['payer'];
	@$uPtype = $_GET['ptype'];
	@$uChurch = $_GET['church'];
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>	Congregation Link Subscription</title>
	<link rel="stylesheet" href="_css/style.css">
	<link rel="stylesheet" href="jquery-ui.css">
</head>
<body>
	<div>
		<header id="header-container">
			<nav class="cf">
				<ul>
					<!-- <li><a a href="#" onclick="close_window();return false;" class="current">Payments Update</a></li> -->
				</ul>
			</nav>
		</header>
		<section id="body-container">
			<?php
		// Update Form
			$up_name = null;
			$up_amt = null;
			$up_date = null;
			$up_payer = null;
			$up_type = null;
			$up_church = null;

		// Retrieving from post
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				$up_name = $_POST['upname'];
				$up_amt = $_POST['upamt'];
				$up_date = strtotime($_POST['date']);
				$up_payer = $_POST['uppayer'];
				$up_type = $_POST['uptype'];
				$up_church = $_POST['upchurch'];


			// Establishing Data Conection
				$db = Database::connection();
				if (isset($up_name) && isset($up_amt) && isset($up_date) && isset($up_payer) && isset($up_type) && isset($up_church)
					&& !empty($up_name) && !empty($up_amt) && !empty($up_date)
					&& !empty($up_payer) && !empty($up_type) && !empty($up_church)) {
					
			// Generating Query Statement
					$sql = "UPDATE payment SET payment_subscription =?, payment_amount =?, payment_date =?, payer_id =?, 
				payment_type =?, payment_church =? WHERE payment_id =?";
				$query = $db->prepare($sql);
				if ($query->execute(array($up_name, $up_amt, $up_date, $up_payer, $up_type, $up_church, $uId))) {
					header('location: payments_update.php?success=1');
				} else {
					header('location: payments_update.php?success=0');
				}
			}			
		}
		// Fetching Select Options from terms
		function selectedSub($row_id) {
			global $uStype;

			$selected = null;
			if ($row_id == $uStype) {
				$selected = 'Selected';
			}else {
				$selected = '';
			}
			return $selected;
		}
		// Fetching Select Options from church
		function selectedChurch($row_id) {
			global $uChurch;

			$selected = null;
			if ($row_id == $uChurch) {
				$selected = 'Selected';
			} else {
				$selected = '';
			}
			return $selected;
		}

		?>
		<div class="form-fill">
			<form action="#successBox" method="POST">
				<label for="upname"><span class="input-label">Subscription:</span>
					<div class="select-style">
						<select name="upname" id="upname">
							<option value=""></option>
							<?php
							$db = Database::connection();
							$sql = "SELECT * FROM terms WHERE terms_status = 'a' ";
							Database::disconnect();
							foreach ($db->query($sql) as $rows) {
								echo '<option value='.$rows['terms_id'].' '.selectedSub($rows['terms_id']).' >'.$rows['terms_name'].'</option>';
							}
							?>
						</select>
					</div>
				</label>
				<label for="upamt"><span class="input-label">Amount:</span>
					<input type="text" id="upamt" name="upamt" placeholder="Payment Amount" value="<?php echo $uAmt;?>">
				</label>
				<label for="update"><span class="input-label">Date:</span>
					<input type="date" id="date" name="date"  value="<?php echo strftime("%m/%d/%Y",$uDate);?>"></label>
				<label for="uppayer"><span class="input-label">Client Id:</span>
					<input type="text" id="uppayer" name="uppayer" placeholder="Payer Id" value="<?php echo $uPayer;?>">
				</label>
				<label for="pchurch"><span class="input-label">Church</span>
					<div class="select-style">
						<select name="upchurch" id="upchurch">
							<option value=""></option>
							<?php
							
							// Fetching Select Options from churches
							$db = Database::connection();
							$sql = "SELECT * FROM church WHERE church_status = 'a'";
							Database::disconnect();
							foreach ($db->query($sql) as $rows) {
								echo '<option value='.$rows['church_id'].' '.selectedChurch($rows['church_id']).'>'.$rows['church_name'].'</option>';
							}
							?>
						</select>
					</div>
				</label>
				<label for="ptype"><span class="input-label">Type:</span>
					<input type="radio" id="uptype" name="uptype" value="1" <?php echo $uPtype == 1 ? 'checked' : ' ';?>>Subscription
					<input type="radio" id="uptype" name="uptype" value="2" <?php echo $uPtype == 2 ? 'checked' : ' '; ?>>Donation
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
<script src="jquery.min.js"></script>
	<script src="jquery-ui.js"></script>
	<script>
	
	$('#date').datepicker();
	
	</script>
</body>
</html>