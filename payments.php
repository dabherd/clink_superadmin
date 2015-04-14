<?php
// Payments Query
$payments_query = "SELECT payment.payment_id AS 'Transaction Id', terms.terms_name AS 'Subscription Type', payment_subscription,
payment.payment_amount AS 'Amount', 
FROM_UNIXTIME(payment_date) AS 'Date', payment_date,  payment.payer_firstname, payment.payer_lastname, payment.payer_middlename, payment.payment_type AS 'Payment Type',
church.church_name as Church, payment_church, payment_status 
FROM payment
INNER JOIN terms ON payment.payment_subscription = terms.terms_id
INNER JOIN church ON payment.payment_church = church.church_id 
ORDER BY payment.payment_status ASC";

// Database Connection 
require_once('_lib/connection.class.php');

// Page Status
$current = "current";
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Payments</title>
	<link rel="stylesheet" href="_css/style.css">
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
					<li><a href="subscription.php">Subscription</a></li>
					<li><a href="church.php" >Church</a></li>
					<li><a href="<?php echo $_SERVER['PHP_SELF'];?>" class="<?php echo $current;?>">Payments</a></li>
					<li><a href="terms.php">Terms</a></li>
				</ul>
			</nav>
		</header>
		<section id="body-container">
			<?php
			include('payments_add.inc.php');
			?>
			<div id="table-container">	
				<header id="table-header">
					<h3>Active Payments</h3>
				</header>	
				<table class="table-fill">					
					<thead>
						<tr>
							<th>Transaction Id</th>
							<th>Subscription Type</th>
							<th>Payment Amount</th>
							<th>Payment Date</th>
							<th>Payer Name</th>
							<th>Payment Type</th>
							<th>Selected Church</th>
							<th>Payment Status</th>
							<!-- <th>Action</th>		 -->					
						</tr>
					</thead>
					<tbody class="table-hover">
						<?php
						$db = Database::connection();
						$sql = $payments_query;
						foreach ($db->query($sql) as $rows) {
							echo '<tr>';
							echo '<td>'.$rows['Transaction Id'].'</td>';
							echo '<td>'.$rows['Subscription Type'].'</td>';
							echo '<td>'.$rows['Amount'].'</td>';
							echo '<td>'.$rows['Date'].'</td>';
							echo '<td>'.$rows['payer_firstname'].' '.$rows['payer_lastname'].','.substr($rows['payer_middlename'], 0, 1).'.</td>';
							if ($rows['Payment Type'] == 1) {
								echo '<td>Subscription</td>';
							} else {
								echo '<td>Donation</td>';
							}
							echo '<td>'.$rows['Church'].'</td>';
							switch ($rows['payment_status']) {
								case 'a':
								echo '<td class="active">Active</td>';
								break;
								case 'e':
								echo '<td class="expired">Expired</td>';
								break;
								case 'p':
								echo '<td class="pending">Pending</td>';
								break; 

							}
							// echo '<td class="button-container">
							// <a onclick="updateWindow('.$rows['Transaction Id'].', '.$rows['payment_subscription'].', '.$rows['Amount'].', '.$rows['payment_date'].', '.$rows['Payer Id'].', '.$rows['Payment Type'].', '.$rows['payment_church'].')" 
							// class="button update" title="Update">&nbsp</a>
							// <a onclick="if(!confirm(\'Delete?\')) return false;" href="payments_delete.php?id='.$rows['Transaction Id'].'" class="button delete" title="Delete">&nbsp</a></td>';
							echo '</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</section>
		<footer id="footer-container">
			<a href="#">Congregation Link 2014-2015</a>
		</footer>
		<div id="modal-container">
			
			<!-- Modal Confirm -->
			<a href="#x" class="overlay" id="successBox"></a>
			<div id="modal-box-pop">
				<a href="payments.php" class="close"></a>
				<?php
				if (isset($_GET['success'])) {
					if ($_GET['success'] == 1) {
						echo '<h5 class="ok">Payment Added</h5>';
					} else {
						echo '<h5 class="error">Faile to add new Payment</h5>';
					}
				}
				?>
			</div>
		</div>
	</div>
	<script>
	function updateWindow(id, stype, amt, date, payer, ptype, church) {
		var u_id = id;
		var u_stype = stype;
		var u_amt = amt;
		var u_date = date;
		var u_payer = payer;
		var u_ptype = ptype;
		var u_church = church;
		var myWindow = window.open("payments_update.php?id="+u_id+"&stype="+u_stype+"&amt="+u_amt+"&date="+u_date+"&payer="+u_payer+"&ptype="+u_ptype+"&church="+u_church, "",
			"width=500, height=500, top=145, left=0");
		return myWindow;
	}
	</script>
</body>
</html>