<?php
	function verify_cust_id($cust_id){

		$conn = pg_connect("host= port= dbname= user= password=") or die("Could not connect");

		$result = pg_query($conn, "SELECT * FROM adressen WHERE id=$cust_id");

		if (!$result) {
  			echo "An error occurred.\n";
		}else{

			$rows = pg_num_rows($result);

			return $rows;

		}
		
		pg_close($conn);
	}
?>
