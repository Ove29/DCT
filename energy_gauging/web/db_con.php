<?php
 	include 'db.php';

	$db_con = mysqli_connect (DB_HOST,DB_USER,DB_PASS,DB_BASE);

        if (mysqli_connect_errno()){
        	echo "Failed to connect to MySQLi: " . mysqli_connect_error(); 
	}
?>
