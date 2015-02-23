<?php
	include 'db_con.php';

	if(isset($_POST['stat'])) {
		$stat = $_POST['stat'];

		if($stat==1){
			$out_id = $_POST['out_id'];
			$dp_id = $_POST['dp_id'];

			$sql = "SELECT * FROM output WHERE dp_meter_id='$dp_id' AND output_id='$out_id'";
			$result = mysqli_query($db_con,$sql) OR die(mysqli_error($db_con));
			$row = mysqli_fetch_array($result);

			echo '
				<form class="form-horizontal" action="index.php?group=output&site=edit" method="post">
					<div class="form-group">
						<label for="dp_id" class="control-label col-xs-2">DP-Meter</label>
						<div class="col-xs-10">
							<input name="dp_id" id="dp_id" type="text" class="form-control" value="' . $row['dp_meter_id'] . '" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="out_id" class="control-label col-xs-2">Output</label>
						<div class="col-xs-10">
							<input name="out_id" id="out_id" type="text" class="form-control" value="' . $row['output_id'] . '" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="cust_id" class="control-label col-xs-2">Customer ID</label>
						<div class="col-xs-10">
							<input name="cust_id" id="cust_id" type="text" class="form-control"';
								if($row['customer_id']==0){
 									echo 'placeholder="0000"'; 
								}else{
									echo 'value="' . $row['customer_id'] . '"'; 
								}
								echo 'required="required" pattern="[0-9]{4}">
						</div>
					</div>
					<div class="form-group">
						<label for="rack_id" class="control-label col-xs-2">Rack ID</label>
						<div class="col-xs-10">
							<input name="rack_id" id="rack_id" type="text" class="form-control"';
								if($row['customer_id']==0){
									echo 'placeholder="000000a"';
								}else{
									echo 'value="' . $row['rack_id'] . '"';
								}
								echo 'required="required" pattern="[0-9]{6}[abc]{0,1}">
						</div>
					</div>
					<input type="hidden" name="stat" id="stat" value="5">
					<div class="form-group">
						<label for="del_out" class="control-label col-xs-2">Clear Output</label>
						<div class="col-xs-offset-0 col-xs-1">
							<input name="del_out" id="del_out" type="checkbox" class="form-control" value="111">
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-offset-3 col-xs-9 col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2">
							<input type="submit" class="btn btn-primary" value="Submit" name="sub_btn">
							<input type="reset" class="btn btn-warning" value="Reset Form">
							<input type="submit" class="btn btn-danger" value="Clear Output" name="sub_btn">
						</div>
					</div>
				</form>
			';
		}elseif($stat==5){
			$out_id = $_POST['out_id'];
			$dp_id = $_POST['dp_id'];
			$cust_id = $_POST['cust_id'];
			$rack_id = $_POST['rack_id'];
			$del = $_POST['del_out'];
			$btn = $_POST['sub_btn'];

			if ($btn=='Clear Output'){
				if ($del==111){
					$sql = "UPDATE output SET customer_id=0, rack_id=0000000 WHERE dp_meter_id='$dp_id' AND output_id='$out_id'";
					if(!mysqli_query($db_con,$sql)){
						die('Error: ' . mysqli_error($db_con));
					}else{
						echo 'Output Cleared';
					}
				}else{
					echo 'You missed the Ceckbox';
				}
			}else{
				include_once 'check/cust_id.php';
				$result = verify_cust_id($cust_id);

				if ($result==1){
					$sql = "UPDATE output SET customer_id=$cust_id, rack_id='$rack_id', dp_meter_id='$dp_id', output_id='$out_id' WHERE dp_meter_id='$dp_id' AND output_id='$out_id'";
					if(!mysqli_query($db_con,$sql)){
						die('Error: ' . mysqli_error($db_con));
					}else{
						echo "DONE";
					}
				}else{
					echo "Wrong Customer ID";
				}
			}
		}else{
			echo "please report this Bug to Ove";
		}
	}else{
		$sql = "SELECT * FROM dp_meter";
		$result = mysqli_query($db_con,$sql) OR die(mysqli_error($db_con));
		echo '
			<form class="form-horizontal" action="index.php?group=output&site=edit" method="post">
				<div class="form-group">
					<label for="dp_id" class="control-label col-xs-2">DP-Meter</label>
					<div class="col-xs-10">
						<select name="dp_id" id="dp_id" class="form-control" required="required">
		';
			while($row = mysqli_fetch_array($result)) {
				echo ' <option value="' . $row['dp_meter_id'] . '">' . $row['dp_meter_id'] . ' (' . $row['dp_meter_name'] . ')' . '</option>';
			}
		echo '
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="out_id" class="control-label col-xs-2">Output</label>
					<div class="col-xs-10">
						<select name="out_id" id="out_id" class="form-control" required="required">
		';
			for ($i = 1; $i <= 27; $i++){
				$out_id = $i;
				echo ' <option value="' . $out_id . '">' . $out_id . '</option>';
			}
		echo '
						</select>
					</div>
				</div>
				<input type="hidden" name="stat" id="stat" value="1">
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