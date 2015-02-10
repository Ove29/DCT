<?php
	include 'db_con.php';
	$sql = "SELECT * FROM customer_buy ORDER BY customer_id ASC";
	$result = mysqli_query($db_con,$sql) OR die(mysqli_error($db_con));

	while($row = mysql_fetch_object($result))
   {
   echo "$row->customer_id, $row->book100, $row->book300, $row->book05a, $row->book10a, $row->book16a,  <br>";
   }
   
   echo '
			<form class="form-horizontal" action="index.php?site=add-cust" method="post">
				<div class="form-group">
					<label for="name" class="control-label col-xs-2">Customer ID</label>
					<div class="col-xs-10">
						<input name="cust_id" id="cust_id" type="text" class="form-control" placeholder="1234" required="required" pattern="[0-9]{4}">
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="control-label col-xs-2">100w</label>
					<div class="col-xs-10">
						<input name="100w" id="100w" type="number" class="form-control">
 					</div>
				</div>
				<div class="form-group">
					<label for="name" class="control-label col-xs-2">300w</label>
					<div class="col-xs-10">
						<input name="300w" id="300w" type="number" class="form-control">
 					</div>
				</div>
				<div class="form-group">
					<label for="name" class="control-label col-xs-2">5a</label>
					<div class="col-xs-10">
						<input name="5a" id="5a" type="number" class="form-control">
 					</div>
				</div>
				<div class="form-group">
					<label for="name" class="control-label col-xs-2">10a</label>
					<div class="col-xs-10">
						<input name="10a" id="10a" type="number" class="form-control">
 					</div>
				</div>
				<div class="form-group">
					<label for="name" class="control-label col-xs-2">16a</label>
					<div class="col-xs-10">
						<input name="16a" id="16a" type="number" class="form-control">
 					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-offset-3 col-xs-9 col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2">
						<input type="submit" class="btn btn-primary" value="Submit">
						<input type="reset" class="btn btn-default" value="Reset">
					</div>
				</div>
			</form>
		';

	if(isset($_POST['cust_id'])) {
	
	}else{
		
	
	}
?>