<?php
/**
 * This PHP script helps you do the iframe checkout
 *
 */


/**
 * Put your API credentials here:
 * Get these from your API app details screen
 * https://stage.wepay.com/app
 */
$client_id = "xxxxx";
$client_secret = "xxxxxxxxxx";
$access_token = "xxxxxxxxxx";
$account_id = xxxxxxxxx; // you can find your account ID via list_accounts.php which users the /account/find call

/** 
 * Initialize the WePay SDK object 
 */
require 'wepay.php';
Wepay::useStaging($client_id, $client_secret);
$wepay = new WePay($access_token);

/**
 * Make the API request to get the checkout_uri
 * 
 */
try {
	$checkout = $wepay->request('checkout/create', array(
			'account_id' => $account_id, 
			'amount' => $_REQUEST['amnt'], 
			'short_description' => "Product name", 
			'type' => "service",
			'currency' => 'USD'
			
		)
	);
} catch (WePayException $e) { // if the API call returns an error, get the error message for display later
	$error = $e->getMessage();
}

?>
<html>
	<head>
	</head>
	
	<body>
		
		<h1>Please Wait ...</h1>
		
		<p></p>
		
		<?php if (isset($error)): ?>
			<h2 style="color:red">ERROR: <?php echo $error ?></h2>
		<?php else: ?>
			<!-- <div id="checkout_div"></div> -->
		
			<!--<script type="text/javascript" src="https://stage.wepay.com/js/iframe.wepay.js">
			</script> -->
			
			<script type="text/javascript">
				//WePay.iframe_checkout("checkout_div", "<?php echo $checkout->hosted_checkout->checkout_uri ?>");
				window.location.href = "<?php echo $checkout->hosted_checkout->checkout_uri ?>";
			</script>
		<?php endif; ?>
	
	</body>
	
</html>