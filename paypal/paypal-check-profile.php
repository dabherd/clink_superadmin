<?php 
require_once('_lib/functions.php');

if (!isset($_GET['profile_id']) && ! isset($_GET['transaction_id']))
	die('Check Profile Requires a profile id or transaction id specified in the URL ($_GET)');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Paypal Payment Profile</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<?php 
		if (isset($_GET['profile_id'])) : $paypal = create_example_subscription();
		if (isset($_GET['action'])) {
			$paypal->manage_subscription_status($_GET['profile_id'], 'Suspend', 'Suspended subscription via PayPal Digital Goods PHP Example');
		} elseif ('cancel' == $_GET['action']) {
			$paypal->manage_subscription_status($_GET['profile_id'], 'Cancel', 'Cancelled subscription via PayPal Digital Goods PHP Example');
		} elseif ('reactivate' == $_GET['action']) {
			$paypal->manage_subscription_status($_GET['profile_id'], 'Reactivate', 'Reactivated subscription via PayPal Digital Goods PHP Example');
		}
		?>
		<h2>Paypal Subscription Details</h2>
		<pre>
			$paypal->get_profile_details($_GET['profile_id']) =
			<?php $profile_details = $paypal->get_profile_details($_GET['profile_id']); ?>
			<?php print_r($profile_details); ?>
		</pre>
		<?php if ('Active' == $profile_details['STATUS']) : ?>
		<p><a href="<?php echo get_script_ur('check-profile.php?profile_id='. $_GET['profile_id']. '&action=suspend') ?>" target="_top">Suspend Subscription &raquo;</a></p>
		<p><a href="<?php echo get_script_ur('check-profile.php?profile_id=' .$_GET['profile_id']. '&action=cancel') ?>"
			target="_top">Reactivate Subscription &raquo;
		</a></p>
	<?php endif; ?>
<?php else : ?>
	<?php $paypal = create_example_purchase(); ?>
	<h2>PayPal Transaction Details</h2>
	<pre>$paypal->get_transaction_details($_GET['transaction_id'])); =
		<?php print_r($paypal->get_transaction_details($_GET['transaction_id'])) ;?></pre>
	<?php endif; ?>
	<p><a href="<?php echo get_script_uri();?>"
		target="_top">Return to Examples Overview &raquo;</a></p>
	</div>
</body>
</html>