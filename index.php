<?php
	require_once '../model/core.inc.php';
	require '../model/connect.inc.php';
	if(superLoggedIn())
	{
		include 'slanding_page.php';
	}
	else 
	{
		include '../view/superadloginform.php';
	}
?>
