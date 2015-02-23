<?php
	if(isset($_POST['ip'])) {
		include 'db_con.php';
		$gw_name = mysqli_real_escape_string($db_con, $_POST['name']);
		$gw_ip = mysqli_real_escape_string($db_con, $_POST['ip']);
		$gw_desc = mysqli_real_escape_string($db_con, $_POST['desc']);
		$gw_ver = mysqli_real_escape_string($db_con, $_POST['ver']);
		$gw_com = mysqli_real_escape_string($db_con, $_POST['community']);
		$gw_location = mysqli_real_escape_string($db_con, $_POST['location']);
		$err_index = 0;

		if(strlen(trim($gw_name)) == 0) {
			$err_index = 1;
			echo "No Gateway Name</br>";
		}else{
			$sql = "SELECT * FROM gateway WHERE gw_name='$gw_name'";
			if(!mysqli_query($db_con,$sql)){
				die('Error: ' . mysqli_error($db_con));
      	}
      	$return = mysqli_query($db_con,$sql);
      	if(isset($return)) {
      	
      	}else{
      		$err_index = 1;
      		echo "Gateway Name already in use</br>";
      	}
      }
		if(strlen(trim($gw_ip)) == 0) {
			$err_index = 1;
			echo "No IP address</br>";
		}else{
			$sql = "SELECT * FROM gateway WHERE gw_ip='$gw_ip'";
			if(!mysqli_query($db_con,$sql)){
				die('Error: ' . mysqli_error($db_con));
      	}
      	$return = mysqli_query($db_con,$sql);
      	if(isset($return)) {
      	
      	}else{
      		$err_index = 1;
      		echo "IP address already in use</br>";
      	}
      }
		if(strlen(trim($gw_ver)) == 0) {
			$err_index = 1;
			echo "No SNMP version</br>";
		}
		if(strlen(trim($gw_com)) == 0) {
			$err_index = 1;
			echo "No SNMP Community</br>";
		}
		if(strlen(trim($gw_location)) == 0) {
			$err_index = 1;
			echo "No Location</br>";
		}
			
		if($err_index != 0) {
			
		}else{
			$sql = "INSERT INTO gateway 
				(gw_name, gw_ip, gw_snmp_version, gw_snmp_community, gw_location, gw_description)
				VALUES('$gw_name', '$gw_ip', '$gw_ver', '$gw_com', '$gw_location', '$gw_desc')";
      	if(!mysqli_query($db_con,$sql)){
				die('Error: ' . mysqli_error($db_con));
      	}

			$sql = "SELECT * FROM gateway ORDER BY gw_id DESC LIMIT 1";
			$return = mysqli_query($db_con,$sql);
			$row = mysqli_fetch_array($return);

        	echo "Gateway " . $row['gw_name'] . " added width ID: " . $row['gw_id'];
			echo "</br>";

			include_once 'check/gw_ping.php';
			#include_once 'check/gw_snmp.php';
			
			$result = ping_it($gw_ip);
			if ($result==0) {
				$pingresult = "Yes";
			}else{
				$pingresult = "No";
			}
				
			echo "Can i ping it: " . $pingresult;
			#$result = snmp_check($gw_ip,$gw_com,$gw_ver);
			#echo "SNMP: " . $result;
		}
	}else{
		echo '
			<form class="form-horizontal" action="index.php?group=gw&site=add" method="post">
				<div class="form-group">
					<label for="name" class="control-label col-xs-2">Gateway Name</label>
					<div class="col-xs-10">
						<input name="name" id="name" type="text" class="form-control" placeholder="Gateway Name" required="required">
					</div>
				</div>
				<div class="form-group">
					<label for="ip" class="control-label col-xs-2">IP Address</label>
					<div class="col-xs-10">
						<input name="ip" id="ip" type="text" class="form-control" placeholder="000.000.000.000" required="required" pattern="[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}">
					</div>
				</div>
				<div class="form-group">
					<label for="ver" class="control-label col-xs-2">SNMP Version</label>
					<div class="col-xs-2">
						<label class="radio-inline">
							<input type="radio" name="ver" required="required" value="1"> 1
						</label>
				        </div>
					<div class="col-xs-2">
						<label class="radio-inline">
							<input type="radio" name="ver" value="2c"> 2c
						</label>
					</div>
					<div class="col-xs-2">
						<label class="radio-inline">
							<input type="radio" name="ver" value="3"> 3
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="community" class="control-label col-xs-2">SNMP Community</label>
					<div class="col-xs-10">
						<input name="community" id="community" type="text" class="form-control" required="required" value="xyz">
					</div>
				</div>
				<div class="form-group">
					<label for="location" class="control-label col-xs-2">Location</label>
					<div class="col-xs-10">
						<input name="location" id="location" type="text" class="form-control" required="required" placeholder="Wand neben der Tür">
					</div>
				</div>
				<div class="form-group">
					<label for="desc" class="control-label col-xs-2">Description</label>
					<div class="col-xs-10">
						<textarea rows="3" name="desc" id="desc" type="text" class="form-control"></textarea>
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
