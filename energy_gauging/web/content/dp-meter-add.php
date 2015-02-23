<?php
	include 'db_con.php';

	if(isset($_POST['dp_id'])) {
		$dp_id = mysqli_real_escape_string($db_con, $_POST['dp_id']);
		$gw_id = mysqli_real_escape_string($db_con, $_POST['gw_id']);
		$dp_meter_name = mysqli_real_escape_string($db_con, $_POST['dp_name']);
		
		if(isset($dp_id)) {
			$sql = "SELECT * FROM dp_meter  WHERE dp_meter_id='$dp_id'";
			$result = mysqli_query($db_con,$sql) OR die(mysqli_error($db_con));
			$row = mysqli_fetch_array($result);
			$num = mysqli_num_rows($result);
		}else{
			$num = 99;		
		}

		if($num < 1){
			$sql = "INSERT INTO dp_meter (dp_meter_id,dp_meter_name,gw_id) 
						VALUES ('$dp_id', '$dp_meter_name', '$gw_id')";
			if(!mysqli_query($db_con,$sql)){
				die('Error: ' . mysqli_error($db_con));
			} 

			$sql = "SELECT * FROM dp_meter  WHERE dp_meter_id='$dp_id'";
			$result = mysqli_query($db_con,$sql) OR die(mysqli_error($db_con));
			$row = mysqli_fetch_array($result);
			$num = mysqli_num_rows($result);

			echo "Adding DP-Meter ...</br>";

			if($num == 1){
				echo "DP-Meter added width ID: " . $row['dp_meter_id'] . "</br>";
				echo "Creating Ports ... </br>";
			
				for ($i = 1; $i <= 27; $i++){
					$out_id = $i;
					$sql = "INSERT INTO output (dp_meter_id,output_id) VALUES ('$dp_id', '$out_id')";

					if(!mysqli_query($db_con,$sql)){
						die('Error: ' . mysqli_error($db_con));
					}
				}
				$sql = "SELECT * FROM output WHERE dp_meter_id='$dp_id'";
				$result = mysqli_query($db_con,$sql) OR die(mysqli_error($db_con));
				$num = mysqli_num_rows($result);

				if($num == 27){
					echo "</br>" . $num . " Ports created!";
				}else{
					echo " something went wrong ...";
				}
			}else{
				echo " something went wrong ...";
			}
		}elseif($num==99) {
			echo "DP-Meter ID not set";
		}else{
			echo "DP-Meter already exist";
		}
	}else{
		$sql = "SELECT gw_id, gw_name FROM gateway";
		$result = mysqli_query($db_con,$sql) OR die(mysqli_error($db_con));

		echo '
			<form class="form-horizontal" action="index.php?group=dp-meter&site=add" method="post">
				<div class="form-group">
					<label for="name" class="control-label col-xs-2">DP-Meter ID</label>
					<div class="col-xs-10">
						<input name="dp_id" id="dp_id" type="text" class="form-control" placeholder="1234" required="required" pattern="[0-9]{4}">
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="control-label col-xs-2">DP-Meter Name/Location</label>
					<div class="col-xs-10">
						<input name="dp_name" id="dp_name" type="text" class="form-control" placeholder="UVT1" required="required">
 					</div>
				</div>
				<div class="form-group">
					<label for="ip" class="control-label col-xs-2">Gateway</label>
					<div class="col-xs-10">
						<select name="gw_id" id="gw_id" class="form-control" required="required">
		';
			while($row = mysqli_fetch_array($result)) {
				echo ' <option value="' . $row['gw_id'] . '">' . $row['gw_name'] . ' (' . $row['gw_id'] . ')' . '</option>';
			}
		echo '
						</select>
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
	}
?>