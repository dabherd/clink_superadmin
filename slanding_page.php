<?php
// Page status
$current = "current";

// Overview Query
$overview = "SELECT COUNT(*) AS no_subscription, 
(SELECT COUNT(*) FROM church WHERE church_status = 'a')AS no_church , 
(SELECT COUNT(*) FROM terms WHERE terms_status = 'a') as no_terms, 
(SELECT SUM(payment_amount) FROM payment WHERE payment_date >= UNIX_TIMESTAMP( LAST_DAY( CURDATE( ) ) + INTERVAL 1 DAY - INTERVAL 1 MONTH ) 
	AND payment_status = 'a' AND payment_date < UNIX_TIMESTAMP( LAST_DAY( CURDATE( ) ) + INTERVAL 1 DAY )) AS total FROM subscription WHERE subscription_status = 'a'
";


// Active Church Query
$active_church = "SELECT church_name FROM church WHERE church_status = 'a' LIMIT 5";

// New Church Subscription Query
$new_subscripton = "SELECT church.church_name  AS new_church
FROM subscription
INNER JOIN church ON subscription.church_id = church.church_id
WHERE subscription_start >= UNIX_TIMESTAMP(LAST_DAY(CURDATE()) +
	INTERVAL 1 DAY - INTERVAL 1 MONTH)
AND subscription_start < UNIX_TIMESTAMP(LAST_DAY(CURDATE()) + INTERVAL
	1 DAY) AND subscription_status = 'a'";
// Payments Query
$payments_query = "SELECT payment.payment_id AS 'Transaction Id', terms.terms_name AS 'Subscription Type', payment_subscription,
payment.payment_amount AS 'Amount', 
FROM_UNIXTIME(payment_date) AS 'Date', payment_date,  payment.payer_id AS 'Payer Id', payment.payment_type AS 'Payment Type',
church.church_name AS Church, payment_status AS Status
FROM payment
INNER JOIN terms ON payment.payment_subscription = terms.terms_id
INNER JOIN church ON payment.payment_church = church.church_id ";

// Database Connection	
require_once('_lib/connection.class.php');
require_once('_utils/clink_functions.php');

// Subscription Query
$subscription_query = "SELECT subscription.church_id, subscription.terms_id, subscription.payment_id, church.church_name AS name, terms.terms_name AS
type , payment.payment_amount as amount, FROM_UNIXTIME( subscription_start ) AS subscription_start, FROM_UNIXTIME( subscription_start + terms.terms_duration ) AS subscription_end, subscription_status
FROM subscription
INNER JOIN church ON subscription.church_id = church.church_id
INNER JOIN terms ON subscription.terms_id = terms.terms_id
INNER JOIN payment ON subscription.payment_id = payment.payment_id
WHERE subscription.subscription_status = 'a' ";
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>	Congregation Link Subscription</title>
	<link rel="stylesheet" href="_css/style.css">
	<link rel="stylesheet" href="_css/calendar.css">
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
					<li><a href="<?php echo $_SERVER['PHP_SELF'];?>" class="<?php echo $current;?>">Dashboard</a></li>
					<li><a href="subscription.php">Subscription</a></li>
					<li><a href="church.php" >Church</a></li>
					<li><a href="payments.php">Payments</a></li>
					<li><a href="terms.php">Terms</a></li>
				</ul>
			</nav>
		</header>
		<div id="body-container">
			<section id="section-container">
				<div id="super-profile">
					<div>
						<a href="#">Profile</a>
						<a href="logout.php">Logout</a>
					</div>
					<div>
						<a href="#">
							<div id="super-pic" class="circle">
							</div>
						</a>
					</div>
					<div>
						<h3>Paul Calinao</h3>
					</div>
				</div>
				<div id="calendar">
					<!-- Calendar Import -->
					<?php require_once('_utils/calendar.php') ?>
				</div>
			</section>
			<aside id="notification-container">
				<div id="overview-container">
					<?php 
					$db = Database::connection();
					$sql = $overview;
					Database::disconnect();
					foreach($db->query($sql) as $rows) {
						echo '<div>
						<h3>Subscriptions</h3>
						<p>'.$rows['no_subscription'].'</p>
						</div>';
						echo '<div>
						<h3>Churches</h3>
						<p>'.$rows['no_church'].'</p>
						</div>';
						echo '<div>
						<h3>'.date('M', time()).' Payments</h3>
						<p>'.$rows['total'].'</p>
						</div>';
						echo '<div>
						<h3>Terms</h3>
						<p>'.$rows['no_terms'].'</p>
						</div>';
					}
					?>
				</div>
				<div id="find-container">
					<div id="search-container">
						<form action="post">
							<ul>
								<li><input type="text" placeholder="search"></li>

							</ul>
						</form>
					</div>
					<p id="t"></p>
				</div>
				<div id="log-container">
					<table class="table-fill">
						<thead>
							<th>LogFile</th>
						</thead>
						<tbody class="table-hover">
							<?php //readLog(); ?>
						</tbody>
					</table>
				</div>
			</aside>
		</div>
		<footer id="footer-container">
			<a href="#">Congregation Link 2014-2015</a>
		</footer>
	</div>
	<script>
	var time =(function() {
		var d = new Date();
		h = d.getHours();
		m = d.getMinutes();
		s = d.getSeconds();

		if (h < 10)	{ h = "0" + h};
		if (m < 10) { m = "0" + m};
		if (s < 10) { s = "0" + s};

		document.getElementById("t").innerHTML = h + ':' + m + ':' + s;

		setTimeout(function() { time(), 1000});
	});

	window.onload = time();
	</script>
</body>
</html>