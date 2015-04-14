<?php
// Database Connection
require_once('_lib/connection.class.php');

$payments_query = "SELECT payment.payment_id AS 'Transaction Id', terms.terms_name AS 'Subscription Type', payment_subscription,
payment.payment_amount AS 'Amount', 
FROM_UNIXTIME(payment_date) AS 'Date', payment_date,  payment.payer_firstname, payment.payer_lastname, payment.payer_middlename, payment.payment_type AS 'Payment Type',
church.church_name as Church, payment_church, payment_status 
FROM payment
INNER JOIN terms ON payment.payment_subscription = terms.terms_id
INNER JOIN church ON payment.payment_church = church.church_id  
WHERE payment_status = 'p' AND church_status = 'i'";

// Initializing form variables
$s_church_id = null;
$s_terms_id = null;
$s_pay_id = null;
$s_start = null;
$s_status = null;

// Validates input field
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Retrieving form post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$s_church_id = test_input($_POST['schurch']);
	$s_terms_id = test_input($_POST['sterms']);
	$s_pay_id = test_input($_POST['spay']);
	$s_start = time();
	$s_status = test_input($_POST['sstatus']);
	
	// Establishing Database Connection
	$db = Database::connection();

	// Generating Query Statement
	$sql = "SELECT * FROM subscription WHERE church_id =? AND terms_id =? AND payment_id =?";
	$query = $db->prepare($sql);
	$query->execute(array($s_church_id, $s_terms_id, $s_pay_id));
	
	// Query Provided, Closing Connection
	Database::disconnect();
	if ($query->fetch()) {
		header('location: subscription.php?success=0');
	} else {

		// New Connection 
		$db = Database::connection();
		if (isset($s_church_id) && isset($s_terms_id) && isset($s_pay_id) && isset($s_status) && !empty($s_church_id) && !empty($s_terms_id) && !empty($s_pay_id) && !empty($s_status)) {
			$sql = "INSERT INTO subscription(church_id, terms_id, payment_id, subscription_start, subscription_status) VALUES(?, ?, ?, ?, ?)";
			$usql = "UPDATE church SET church_status = 'a' WHERE church_id =? ";
			
			// Adding Subscription
			$query = $db->prepare($sql);
			$query->execute(array($s_church_id, $s_terms_id, $s_pay_id, $s_start, $s_status));
			
			// Updating Church Status
			$uquery = $db->prepare($usql);
			$uquery->execute(array($s_church_id));
			
			// Closing Connection
			Database::disconnect();
			header('location: subscription.php?success=1');
		} else {
			header('location: subscription.php?success=0');
		} 

	}
}

?>
<div id="form-container">
	<header id="form-header">
		<h3>Add New Subscription</h3>
	</header>
	<table class="table-fill-add">
		<thead>
			<th>Name</th>
			<th>Type</th>
			<th>Amount</th>
			<th>Date</th>
			<th>Church</th>
			<th>Add</th>
		</thead>
		<tbody class="table-hover-add">
			<?php 
			$db = Database::connection();
			$asql = $payments_query;
			foreach ($db->query($asql) as $rows) {
				echo '<tr>';
				echo '<td>'.$rows['payer_firstname'].' '.substr($rows['payer_middlename'], 0, 1).' '.$rows['payer_lastname'].'</td>';
				echo '<td>'.$rows['Subscription Type'].'</td>';
				echo '<td>'.$rows['Amount'].'</td>';
				echo '<td>'.$rows['Date'].'</td>';
				echo '<td>'.$rows['Church'].'</td>';
				echo '<td class="button-container"><a class="button add"
				href="subscription_add_summary.php?id='.$rows['Transaction Id'].'&first='.$rows['payer_firstname'].'&last='.$rows['payer_lastname'].'
				&middle='.$rows['payer_middlename'].'&type='.$rows['payment_subscription'].'&amount='.$rows['Amount'].'
				&date='.$rows['Date'].'&idate='.$rows['payment_date'].'&church='.$rows['payment_church'].'"></a></td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>
</div>
<!-- Management Notification Box -->
<a href="#x" class="overlay" id="successBox"></a>
<div id="modal-box-pop">
	<a class="close"href="#" onclick="close_window()"></a>
	<?php
	if (isset($_GET['success'])) {
		if ($_GET['success'] == 1) {
			echo '<h5 class="ok">Subscription Updated</h5>';
		} else {
			echo '<h5 class="error">Failed to Update Subscription</h5>';
		}
	}						
	?>
</div>

<!-- Update Notification Box -->
<a href="#x" class="overlay" id="updateBox"></a>
<div id="modal-box-pop">
	<a class="close"href="#" onclick="close_window()"></a>
</div>

<!-- Table Row Link -->
<script>
$('document').ready(function() {
	$('tr#row-link-subscription').click(function() {
		window.location = $(this).attr('data-href');
		return false;
	});

	$('.push').click(function(){
		var essay_id = $(this).attr('id');

		$.ajax({
			type : 'post',
           url : 'your_url.php', // in here you should put your query 
          data :  'post_id='+ essay_id, // here you pass your id via ajax .
                     // in php you should use $_POST['post_id'] to get this value 
                     success : function(r)
                     {
              // now you can show output in your modal 
              $('#mymodal').show();  // put your modal id 
              $('.something').show().html(r);
          }
      });
	});

	var tRows = $('.table-hover-add > tr').length;

	if (tRows == 0) {
		$('.table-fill-add > thead').replaceWith("<h2>No Active Subscriptions</h2>");
	}
});





</script>
