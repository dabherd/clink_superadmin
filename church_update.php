<?php
// Page Status
$current = "current";
// Database Connection
require_once('_lib/connection.class.php');

// GET Variables
if ($_GET) {
	@$uId = $_GET['id'];
	@$uName = $_GET['name'];
	@$uAdr = $_GET['addr'];
	@$uCon = $_GET['contact'];
	@$uPar = $_GET['parish'];
	@$uPri = $_GET['priest'];
	@$uPat = $_GET['patron'];
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>	Congregation Link Update</title>
	<link rel="stylesheet" href="_css/style.css">
</head>
<body>
	<div>
		<section id="body-container">
			<?php
		// Update Form
			$uc_name = null;
			$uc_addr = null;
			$uc_contact = null;
			$uc_parish = null;
			$uc_priest = null;
			$uc_patron = null;

		// Retrieving from post
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				$uc_name = $_POST['ucname'];
				$uc_addr = $_POST['ucaddr'];
				$uc_contact = $_POST['uccontact'];
				$uc_parish = $_POST['ucparish'];
				$uc_priest = $_POST['ucpriest'];
				$uc_patron = $_POST['ucpatron'];

			// Establishing Data Conection
				$db = Database::connection();
				if (isset($uc_name) && isset($uc_addr) && isset($uc_contact) && isset($uc_parish) && isset($uc_priest) && isset($uc_patron)
					&& !empty($uc_name) && !empty($uc_addr) && !empty($uc_contact) && !empty($uc_parish) && !empty($uc_priest) && !empty($uc_patron)) {
					
			// Generating Query Statement
					$sql = "UPDATE church SET church_name =?, church_addr =?, church_contact =?, church_Parish =?, church_ppriest =?, church_Patron =? WHERE church_id =?";
				$query = $db->prepare($sql);
				if ($query->execute(array($uc_name, $uc_addr, $uc_contact, $uc_parish, $uc_priest, $uc_patron, $uId))) {
					header('location: church_update.php?success=1');
				} else {
					header('location: church_update.php?success=0');
				}
			}			
		}
		?>
		<div class="form-fill">
			<form action="#successBox" method="POST">
				<label for="ucname"><span class="input-label">Church Name:</span>
					<input type="text" id="ucname" name="ucname" value="<?php echo $uName;?>" autofocus>
				</label>
				<label for="ucaddr"><span class="input-label">Church Address:</span>
					<input type="text" id="ucaddr" name="ucaddr" value="<?php echo $uAdr?>">
				</label>
				<label for="uccontact"><span class="input-label">Church Contact:</span>
					<input type="text" id="uccontact" name="uccontact" value="<?php echo $uCon?>">
				</label>
				<label for="ucparish"><span class="input-label">Church Parish:</span>
					<input type="text" id="ucparish" name="ucparish" value="<?php echo $uPar?>">
				</label>
				<label for="ucpriest"><span class="input-label">Church Priest:</span>
					<input type="text" id="ucpriest" name="ucpriest" value="<?php echo $uPri?>">
				</label>
				<label for="ucpatron"><span class="input-label">Church Patron:</span>
					<input type="text" id="ucpatron" name="ucpatron" value="<?php echo $uPat?>">
				</label>	
				<input type="submit" value="Update" class="button">
			</form>
		</div>
	</section>
</div>
<a href="#x" class="overlay" id="successBox"></a>
<div id="modal-box-pop">
	<a class="close"href="#" onclick="close_window()"></a>
	<?php
	if (isset($_GET['success'])) {
		if ($_GET['success'] == 1) {
			echo '<h5 class="ok">Subscription Term Updated</h5>';
		} else {
			echo '<h5 class="error">Failed to Update  Subscription Term</h5>';
		}
	}						
	?>
</div>
<script>
function close_window() {
	if (confirm("Close Window?")) {
		close();
	}
}
</script>
</body>
</html>