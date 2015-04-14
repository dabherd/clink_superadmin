<?php
// Database Connection
require_once('_lib/connection.class.php');
// Page Status
$current = "current";
// Passed Values
if (isset($_GET)) {
	@$id = $_GET['id'];
	@$first = $_GET['first'];
	@$last = $_GET['last'];
	@$middle = $_GET['middle'];
	@$type = $_GET['type'];
	@$amount = $_GET['amount'];
	@$idate = $_GET['idate'];
	@$date = $_GET['date'];
	@$church = $_GET['church'];
}
$terms_query = "SELECT * FROM terms WHERE terms_id =?";
$church_query = "SELECT * FROM church WHERE church_id =?";
$db = Database::connection();
// Terms
$tsql = $terms_query;
$tquery = $db->prepare($tsql);
$tquery->execute(array($type));
$trow = $tquery->fetch(PDO::FETCH_ASSOC);
if ($trow > 0) {
	$end_date = $idate + $trow['terms_duration'];
} else {
	$end_date = '';
}
// Church
$csql = $church_query;
$cquery = $db->prepare($csql);
$cquery->execute(array($church));
$crow = $cquery->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
if ($crow > 0) {
	$church_name = $crow['church_name'];
} else {
	$church_name = '';
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$upayment = $id;
	$uchurch = $church;
	$utype = $type;
	$ustart = $idate;
	$uend = $end_date;
	$ustatus = 'a';

	$db = Database::connection();
	$ssql = "INSERT INTO subscription(church_id, terms_id, payment_id, 
		subscription_start, subscription_end, subscription_status) VALUES(?, ?, ?, ?, ? ,?)";
$squery = $db->prepare($ssql);
Database::disconnect();
if($squery->execute(array($uchurch, $utype, $upayment, $ustart, $uend, $ustatus))) {
	$db = Database::connection();
	$psql = "UPDATE payment SET payment_status = 'a' WHERE payment_id =?";
	$csql = "UPDATE church SET church_status = 'a' WHERE church_id =?";
	$pquery = $db->prepare($psql);
	$cquery = $db->prepare($csql);
	$cquery->execute(array($uchurch));
	$pquery->execute(array($upayment));
	Database::disconnect();
	header('location: subscription_add_summary.php?success=1');
} else {
	header('location: subscription_add_summary.php?success=0');
}

}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>	Congregation Link Subscription</title>
	<link rel="stylesheet" href="_css/style.css">
	<script src="_js/jquery.min.js"></script>
</head>
<body>
	<div>
		<header id="header-body">
			<a href="index.php">
				<section id="section-header">			
				</section>
			</a>
			<nav id="nav-header" class="cf">
				<ul>
					<li><a href="index.php">Dashboard</a></li>
					<li><a href="<?php echo $_SERVER['PHP_SELF'];?>" class="<?php echo $current;?>">Subscription</a></li>
					<li><a href="church.php" >Church</a></li>
					<li><a href="payments.php">Payments</a></li>
					<li><a href="terms.php">Terms</a></li>
				</ul>
			</nav>
		</header>
		<section>
			<div class="form-fill">
				<form action="#successBox" method="POST">
					<label for=""><span class="input-label">Payer Name:</span></label>
					<div id="name-container">
						<label for="sfirst"><span class="input-label">First:</span>
							<input type="text" placeholder="<?php echo $first; ?>"readonly>
							<input type="hidden" id="sfirst" name="sfirst" value="<?php echo $first; ?>">
						</label>
						<label for="slast"><span class="input-label">Last:</span>
							<input type="text" placeholder="<?php echo $last; ?>" readonly>
							<input type="hidden" id="slast" name="slast" value="<?php echo $last; ?>">
						</label>
						<label for="smiddle"><span class="input-label">Middle:</span>
							<input type="text" placeholder="<?php echo $middle; ?>" readonly>
							<input type="hidden" id="smiddle" name="smiddle" value="<?php echo $middle; ?>">
						</label>
					</div>
					<label for="ssubs"><span class="input-label">Subscription:</span>
						<input type="text" placeholder="<?php echo $trow['terms_name']; ?>" readonly>
						<input type="hidden" id="stype" name="stype" value="<?php echo $type; ?>">
					</label>
					<label for="samount"><span class="input-label">Amount:</span>
						<input type="text" placeholder="<?php echo $amount; ?>" readonly>
						<input type="hidden" id="samount" name="samount" value="<?php echo $amount; ?>">
					</label>
					<label for="sstart"><span class="input-label">Start Date:</span>
						<input type="text" placeholder="<?php echo $date; ?>" readonly>
						<input type="hidden" id="sstart" name="sstart" value="<?php echo $date; ?>">
					</label>
					<label for="send"><span class="input-label">End Date:</span>
						<input type="text" placeholder="<?php echo date("Y-m-d h:m:s", $end_date); ?>" readonly>
						<input type="hidden" id="send" name="send" value="<?php echo $end_date; ?>">
					</label>
					<label for="schurch"><span class="input-label">Church Selected:</span>
						<input type="text" placeholder="<?php echo $church_name; ?>" readonly>
						<input type="hidden" id="schurch" name="schurch" placeholder="<?php echo $type ?>">
					</label>
					<div id="button-container">
						<a href="subscription.php" class="button">Back</a>		
						<input type="submit" value="Create" class="button">
					</div>					
				</form>
			</div>
		</section>
		<footer id="footer-container">
			<a href="#">Congregation Link 2014-2015</a>
		</footer>
	</div>
	<div id="modal-container">
		<!-- Modal Confirm -->
		<a href="#x" class="overlay" id="successBox"></a>
		<div id="modal-box-pop">
			<a href="subscription.php" class="close"></a>
			<?php
			if (isset($_GET['success'])) {
				if ($_GET['success'] == 1) {
					echo '<h5 class="ok">Subscription Added</h5>';
				} else {
					echo '<h5 class="error">Failed to add new Subscription</h5>';
				}
			}
			?>
		</div>
	</div>
</body>
</html>