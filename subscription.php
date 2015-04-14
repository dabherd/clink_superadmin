<?php
// Database Connection
require_once('_lib/connection.class.php');

// Subscription Query
$subscription_query = "SELECT subscription.church_id, subscription.terms_id, subscription.payment_id, church.church_name AS name, terms.terms_name AS
type , payment.payment_amount as amount, FROM_UNIXTIME( subscription_start ) AS subscription_start, FROM_UNIXTIME( subscription_start + terms.terms_duration ) AS subscription_end, subscription_status
FROM subscription
INNER JOIN church ON subscription.church_id = church.church_id
INNER JOIN terms ON subscription.terms_id = terms.terms_id
INNER JOIN payment ON subscription.payment_id = payment.payment_id
WHERE subscription.subscription_status = 'a' ";

// Page Status
$current = "current";

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
		
		<section id="body-container">
			<?php
			include('subscription_add.inc.php');
			?>
			<div id="table-container">
				<header id="table-header">
					<h3>Active Subscriptions</h3>
				</header>
				<table class="table-fill">
					<thead>
						<tr>
							<th>Church</th>
							<th>Type</th>
							<th>Amount Paid</th>
							<th>Start</th>
							<th>End</th>
							<th>Status</th>				 	
							<th>Action</th>	
						</tr>
					</thead>
					<tbody class="table-hover">
						<?php
						$db = Database::connection();
						$sql = $subscription_query;
						foreach ($db->query($sql) as $rows) {
							echo '<tr>';
							echo '<td>'.$rows['name'].'</td>';
							echo '<td>'.$rows['type'].'</td>';
							echo '<td>'.$rows['amount'].'</td>';
							echo '<td>'.$rows['subscription_start'].'</td>';
							echo '<td>'.$rows['subscription_end'].'</td>';
							if ($rows['subscription_status'] == 'a') {
								echo '<td class="active">Active</td>';
							} else {
								echo '<td class="inactive">Inactive</td>';
							}
							echo '<td class="button-container">
							<a onclick="updateWindow('.$rows['church_id'].', '.$rows['terms_id'].', '.$rows['payment_id'].', \''.$rows['subscription_start'].'\', \''.$rows['subscription_end'].'\', \''.$rows['subscription_status'].'\')"
							class="button update" title="Update">&nbsp</a>
							<a onclick="if(!confirm(\'Delete?\')) return false;" href="subscription_delete.php?name='.$rows['church_id'].'&type='.$rows['terms_id'].'" class="button delete" title="Delete">&nbsp</a></td>';
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
	</div>
	<script>
	function updateWindow(cid, tid, pid, start, end, status) {
		var u_cid = cid;
		var u_tid = tid;
		var u_pid = pid;
		var u_start = start;
		var u_end = end;
		var u_status = status;
		var myWindow = window.open("subscription_update.php?cid="+u_cid+"&tid="+u_tid+"&pid="+u_pid+"&start="+u_start+"&end="+u_end+"&status="+u_status, "",
			"width=500, height=500, top=145, left=0");
		return myWindow;
	}
	</script>
</body>
</html>