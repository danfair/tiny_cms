<?php
	define("DB_NAME", "first_php");
	define("DB_USER", "site_user");
	define("DB_PASS", "firstphp");
	define("DB_HOST", "localhost");
	$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if (mysqli_connect_errno()) 
	{
		echo mysqli_connect_errno();
	}
?>