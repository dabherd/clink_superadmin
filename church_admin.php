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
			<a href="index.php">
				<section id="section-header">			
				</section>
			</a>
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
				<li><a class="scurrent" href="church_admin.php">Administrators</a></li>
			</ul>
		</nav>
		<section id="body-container">
			<?php
			include('church_admin_add.inc.php');
			?>
			<div id="table-container">
				<header id="table-header">
					<h3>Church Administrators</h3>
				</header>
				<table class="table-fill">					
					<thead>
						<tr>
							<th>Id</th>
							<th>Church</th>
							<th>Username</th>
							<th>Name</th>
							<th>Gender</th>
							<th>Address</th>
							<th>Email</th>
							<th>Contact</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody class="table-hover">
						<?php
						$db = Database::connection();
						$sql = "SELECT church.church_name, users.* FROM users INNER JOIN church ON users.church_id = church.church_id WHERE user_status = 'a' AND user_type = 'admin' ";
						foreach ($db->query($sql) as $rows) {
							echo '<tr>';
							echo '<td>'.$rows['user_id'].'</td>';
							echo '<td>'.$rows['church_name'].'</td>';
							echo '<td>'.$rows['username'].'</td>';
							echo '<td>'.$rows['user_firstname'].'&nbsp'.$rows['user_mi'].'&nbsp'.$rows['user_lastname'].'</td>';
							echo '<td>'.$rows['user_gender'].'</td>';
							echo '<td>'.$rows['user_addr'].'</td>';
							echo '<td>'.$rows['user_email'].'</td>';
							echo '<td>'.$rows['user_contact'].'</td>';
							echo '<td class="button-container">
							<a onclick="updateWindow('.$rows['user_id'].', \''.$rows['username'].'\', \''.$rows['user_firstname'].'\', \''.$rows['user_lastname'].'\', \''.$rows['user_mi'].'\', \''.$rows['user_gender'].'\', \''.$rows['user_addr'].'\', \''.$rows['user_email'].'\', \''.$rows['user_contact'].'\')"  class="button update" title="Update">&nbsp</a>
							<a onclick="if(!confirm(\'Delete?\')) return false; " href="church_admin_delete.php?id='.$rows['user_id'].'" class="button delete" title="Delete">&nbsp</a></td>';
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
				<a href="church_admin.php" class="close"></a>
				<?php
				if (isset($_GET['success'])) {
					if ($_GET['success'] == 1) {
						echo '<h5 class="ok">Church Admin Added</h5>';
					} else {
						echo '<h5 class="error">Failed to add new Administrator</h5>';
					}
				}
				?>
			</div>
		</div>
	</div>
	<script>
	function updateWindow(id, username, first, last, mi, gender, addr, email, contact) {
		var u_id = id;
		var u_username = username;
		var u_first = first;
		var u_last = last;
		var u_mi = mi;
		var u_gender = gender;
		var u_addr = addr;
		var u_email = email;
		var u_contact = contact;
		var myWindow = window.open("church_admin_update.php?id="+u_id+"&username="+u_username+"&first="+u_first+"&last="+u_last+"&mi="+u_mi+"&gender="+u_gender+"&addr="+u_addr
			+"&email="+u_email+"&contact="+u_contact, "", "width=500, height=500, top=145, left=0");
		return myWindow;
	}
	</script>
</body>
</html>