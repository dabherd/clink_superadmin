<?php 
/**
 * Get the PayPal Digital Goods class definitions from the PayPal Digital Goods PHP Library.
 */
require_once('paypal-subscription.class.php');

/**
 * A central function for setting the credentials for both subscription & purchase objects with PayPal Digital Goods Configuration registry class.
 */

function set_credentials() {
	PayPalDigitalGoodsConfiguration::username( 'powlyowly-facilitator_api1.gmail.com' );
	PayPalDigitalGoodsConfiguration::password( 'TQTZTEW9FXS7PLW8' );
	PayPalDigitalGoodsConfiguration::signature( 'AFcWxV21C7fd0v3bYYYRCpSSRl31ALC4i2pkxASbq7NyeG7GQ5AYnZLF' );

	PayPalDigitalGoodsConfiguration::return_url(get_script_uri('return.php?paypal=paid'));
	PayPalDigitalGoodsConfiguration::cancel_url(
		get_script_uri('return.php?paypal=cancel'));
	PayPalDigitalGoodsConfiguration::business_name('Congregation Link');

	PayPalDigitalGoodsConfiguration::notify_url(
		get_script_uri('return.php?paypal=notify'));
	// Uncomment the line below to switch to the live PayPal site
	// PayPalDigitalGoodsConfiguration::environment('live');


	if( PayPalDigitalGoodsConfiguration::username() == 'your_api_username' || PayPalDigitalGoodsConfiguration::password() == 'your_api_password' || PayPalDigitalGoodsConfiguration::signature() == 'your_api_signature' )
		exit( 'You must set your API credentials in ' . __FILE__ . ' for this example to work.' );
}
function create_example_subscription() {
	set_credentials();
	$subscription_details = Array();

	if ($_GET) {
		$subscription_details = array(

			'description' => $_GET['subscription'],
			'initial_amount' => $_GET['amount'],
			'amount' => $_GET['amount'],
			'period' => $_GET['date'],
			'frequency' => $_GET['payer'],
			'total_cycles' => $_GET['type']);
	} 
	return new PayPalSubscription($subscription_details);
}
function get_script_uri($script = 'index.php') {
	// IIS Fix
	if (empty($_SERVER['REQUEST_URI']))
		$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
	// Strip off query string
	$url = preg_replace('/\?.*$/', '', $_SERVER['REQUEST_URI']);
	$url = 'http://'.$_SERVER['HTTP_HOST'].implode('/', (explode('/', $_SERVER['REQUEST_URI'], -1))).'/';
	return $url .$script;
}
?>