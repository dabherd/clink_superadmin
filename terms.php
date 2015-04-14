<?php
// Database Connection
require_once('_lib/connection.class.php');

// Page Status
$current = "current";
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Terms</title>
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
					<li><a href="payments.php">Payments</a></li>
					<li><a href="<?php echo $_SERVER['PHP_SELF'];?>" class="<?php echo $current;?>">Terms</a></li>
				</ul>
			</nav>
		</header>
		<section id="body-container">
			<?php
			include_once('terms_add.inc.php');
			?>
			<div id="table-container">
				<header id="table-header">
					<h3>Active Terms</h3>
				</header>
				<table class="table-fill">
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>Amount</th>
							<th>Duration</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody class="table-hover">
						<?php
						$db = Database::connection();
						$sql = "SELECT * FROM terms WHERE terms_status = 'a'";
						foreach($db->query($sql) as $rows) {
							echo '<tr>';
							echo '<td>'.$rows['terms_id'].'</td>';
							echo '<td>'.$rows['terms_name'].'</td>';
							echo '<td>'.$rows['terms_amount'].'</td>';
							echo '<td>'.$rows['terms_duration'] / (86400).' Days</td>';
							echo '<td class="button-container">
							<a onclick="updateWindow('.$rows['terms_id'].', \''.$rows['terms_name'].'\', '.$rows['terms_amount'].')" class="button update" title="Update">&nbsp</a>
							<a onclick="if(!confirm(\'Delete?\')) return false;" href="terms_delete.php?id='.$rows['terms_id'].'" class="button delete" title="Delete">&nbsp</a></td>';
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
				<a class="close"href="terms.php"></a>
				<?php
				if (isset($_GET['success'])) {
					if ($_GET['success'] == 1) {
						echo '<h5 class="ok">Subscription Term Added</h5>';
					} else {
						echo '<h5 class="error">Failed to add new Subscription Term</h5>';
					}
				}						
				?>
			</div>
		</div>
	</div>
</div>
<script>
function updateWindow(id, name, amt) {
	var u_id = id;
	var u_name = name;
	var u_amt = amt;
	var myWindow = window.open("terms_update.php?id="+u_id+"&name="+u_name+"&amt="+u_amt, "", "width=500, height=500, top=145, left=0");
	return myWindow;
}
</script>
</body>
</html>