<?php 
require_once('_lib/functions.php');

if (!isset($_GET['profile_id'])) {
	die('Cancelling a Profile Requires a profile_id specified in the URL ($_GET)');
}
$action = isset($_GET['action']) ? $_GET['action'] : 'Suspend';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Cancel Paypal Payment</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<?php $paypal = create_example_subscription(); ?>
		<?php $response = $paypal->manage_subscription_status($_GET['profile_id'], $action); ?>
		<?php error_log('$response = '. print_r($response, TRUE)); ?>
		<h2>PayPal Subscription Management Response</h2>
		<pre>$paypal->manage_subscription_status($_GET['profile_id'], '<?php echo $action;?>')) = <?php
		print_r($response);?>></pre>
		<p><a href="<?php echo get_script_uri();?>" target="_top">Return to Examples Overview &raquo;</a></p>
	</div>
</body>
</html>