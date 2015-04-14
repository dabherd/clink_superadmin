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
	<title>Church</title>
	<link rel="stylesheet" href="_css/style.css">
</head>
<body>
	<div>
		<header id="header-body">
			<section id="section-header">
			</section>
			<nav id="nav-header" class="cf">
				<ul>
					<li><a href="index.php">Dashboard</a></li>
					<li><a href="subscription.php">Subscription</a></li>
					<li><a href="<?php echo $_SERVER['PHP_SELF'];?>" class="<?php echo $current;?>">Church</a></li>
					<li><a href="payments.php">Payments</a></li>
					<li><a href="terms.php">Terms</a></li>
				</ul>
			</nav>
		</header>
		<nav id="nav-body">
			<ul>
				<li><a href="church.php">Church</a></li>
				<li><a href="church_admin.php">Administrators</a></li>
				<li><a class="scurrent"  href="church_status.php">Status</a></li>
			</ul>
		</nav>
		<section id="body-container">
			<?php
			include('church_add.inc.php');
			?>
			<div id="table-container">
				<header id="table-header">
					<h3>Active Churches</h3>
				</header>
				<table class="table-fill">					
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>Address</th>
							<th>Contact</th>
							<th>Parish</th>
							<th>Priest</th>
							<th>Patron</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody class="table-hover">
						<?php
						$db = Database::connection();
						$sql = "SELECT * FROM church WHERE church_status = 'a'";
						foreach ($db->query($sql) as $rows) {
							echo '<tr>';
							echo '<td>'.$rows['church_id'].'</td>';
							echo '<td>'.$rows['church_name'].'</td>';
							echo '<td>'.$rows['church_addr'].'</td>';
							echo '<td>'.$rows['church_contact'].'</td>';
							echo '<td>'.$rows['church_Parish'].'</td>';
							echo '<td>'.$rows['church_ppriest'].'</td>';
							echo '<td>'.$rows['church_Patron'].'</td>';
							echo '<td class="button-container">
							<a onclick="updateWindow('.$rows['church_id'].', \''.$rows['church_name'].'\', \''.$rows['church_addr'].'\', \''.$rows['church_contact'].'\', \''.$rows['church_Parish'].'\', \''.$rows['church_ppriest'].'\', \''.$rows['church_Patron'].'\')"  class="button update" title="Update">&nbsp</a>
							<a onclick="if(!confirm(\'Delete?\')) return false; " href="church_delete.php?id='.$rows['church_id'].'" class="button delete" title="Delete">&nbsp</a></td>';
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
				<a href="church.php" class="close"></a>
				<?php
				if (isset($_GET['success'])) {
					if ($_GET['success'] == 1) {
						echo '<h5 class="ok">Church Added</h5>';
					} else {
						echo '<h5 class="error">Failed to add new Church</h5>';
					}
				}
				?>
			</div>
		</div>
	</div>
	<script>
	function updateWindow(id, name, addr, contact, parish, priest, patron) {
		var u_id = id;
		var u_name = name;
		var u_addr = addr;
		var u_contact = contact;
		var u_parish = parish;
		var u_priest = priest;
		var u_patron = patron;
		var myWindow = window.open("church_update.php?id="+u_id+"&name="+u_name+"&addr="+u_addr+"&contact="+u_contact+"&parish="+u_parish+"&priest="+u_priest+"&patron="+u_patron, "", "width=500, height=500, top=145, left=0");
		return myWindow;
	}
	</script>
</body>
</html>