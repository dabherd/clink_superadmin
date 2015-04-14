<?php 
require_once('_lib/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Paypal Return Page</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h2>Paypal Return Page</h2>
		<!-- Returning from Paypal & Payment Cancelled -->
		<?php if (isset($_GET['paypal']) && $_GET['paypal'] == 'cancel') : ?>
		<script>
		if (window!=top) {top.location.replace(document.location);}
		</script>
		<p>Your subscription has been cancelled.<a href="<?php echo get_script_ur();?>" target="_top">Try again? &raquo;</a></p>
		<!-- Returning from Paypal & Payment Authorised-->
		<?php  elseif(isset($_GET['paypal']) && $_GET['paypal'] == 'paid'):
		// Process the payment or start the Subscription
		if (isset($_GET['PayerID'])) {
			$paypal = create_example_purchase();
			$response = $paypal->process_payment();
		} else {
			$paypal = create_example_subscription();
			$response = $paypal->start_subscription();
		}	
		?>
		<h3>Payment Complete!</h3>
		<?php if(isset($_GET['PayerID'])) { ?>
		<p>Your Transaction ID is <?php echo $response['PAYMENTINFO_0_TRANSACTIONID'];?></p>
		<p>You can use this Transaction ID to see the details of your subscription</p>
		<pre><code>get_transaction_details($response['PAYMENTINFO_0_TRANSACTIONID']);</code></pre>
		<p><a href="<?php echo get_script_ur('check-profile.php?transaction_id='.urlencode($response['PAYMENTINFO_0_TRANSACTIONID']))?>" target="_top">View Transaction Details &raquo;</a></p>
		<?php } else {?>
		<p>Your Payment Profile ID is<?php echo $response['PROFILEID'];?></p>
		<p>You can use this Profile ID to see the details of your subscription like so:</p>
		<pre><code>$paypal->get_profile_details('<?php
		echo $response['PROFILEID'];?>');</code></pre>
		<p><a href="<?php echo get_script_ur('check-profile.php?profile_id='.urlencode($response['PROFILEID'])) ?>" target="_top">
			Check Profile &raquo;</a></p>
			<p>You can use suspend this subscription like this:</p>
			<pre><code>$paypal->manage_subscription_status('<?php echo $response['PROFILEID'];?></code></pre>
			<p><a href="<?php echo get_script_ur('check-profile.php?profile_id='. urlencode($response['PROFILEID']). '&action=suspend')?>" target="_top">Suspend &raquo;</a></p>
			<p>Or permanently cancel it like this:</p>
			<pre><code>$paypal->manage_subscription_status('<?php echo $response['PROFILEID']; ?>',
				'Cancel');</code></pre>
				<p><a href="<?php echo get_script_uri('check-profile.php?profile_id=' .urlencode($response['PROFILEID']). '&action=cancel')?>" target="_top">Cancel &raquo;</a></p>
				<?php }?>
			<?php endif;?>
		</div>
	</body>
	</html>