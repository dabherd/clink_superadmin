<?php 
function logAction($admin, $action) {
	$timeNow = date('Y-m-d h:i:s', time());
	$filename = 'C:\xampp\htdocs\clink\superadmin\_utils\log.txt';
	if (file_exists($filename)) {
		$current = file_get_contents($filename);
		$current .= $admin.":".$action.":".$timeNow."\r\n";
		$handle = file_put_contents($filename, $current, FILE_APPEND | LOCK_EX);
	} else {
		$current = '';
		$handle = file_put_contents($filename, $current);
	}
}

function readLog() {
	$myFile = file('C:\xampp\htdocs\sandbox\clink_superadmin\_utils\log.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$arrLength = count($myFile);
	for ($x = 0; $x < $arrLength; $x++) {
		echo '<tr>';
		echo '<td>'.$myFile[$x].'</td>';
		echo '</tr>';
	}
}
?>



