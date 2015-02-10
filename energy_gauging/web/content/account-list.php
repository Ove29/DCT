<?php
	include 'db_con.php';
	
	$sql = "SELECT * FROM customer_account WHERE level<9";
	if(!mysqli_query($db_con,$sql)){
		die('Error: ' . mysqli_error($db_con));
	}
	
   $return = mysqli_query($db_con,$sql);
	if(isset($return)) {
		if(isset($_POST['stat'])) {
			$stat = mysqli_real_escape_string($db_con, $_POST['stat']);
			$date_now_year = date("Y");
			$date_now_month = date("m");
			if($date_now_month==1) {
				$date_last_year = $date_now_year-1;
				$date_last_month = 12;
			}else{
				$date_last_year = $date_now_year;
				$date_last_month = $date_now_month-1;
			}
		
			$date_now = $date_now_year."-".$date_now_month."-01 02:00:00";
			$date_last = $date_last_year."-".$date_last_month."-01 00:00:00";
		
			$sql = "SELECT * FROM use_month WHERE time BETWEEN '$date_last' AND '$date_now'";
			$result = mysqli_query($db_con,$sql) OR die(mysqli_error($db_con));

			switch($stat) {
				case 1:
					echo 'collecting information...</br></br>';
					
			
					echo '
						<table class="table">
							<thead>
								<tr>
									<th rowspan="2">ID</th>
									<th rowspan="2">Time</th>
									<th rowspan="2">Customer_ID</th>
									<th rowspan="2">Rack_ID</th>
									<th rowspan="2">Output_ID</th>
									<th rowspan="2">Total</th>
									<th rowspan="2">Subtotal</th>
								</tr>
							</thead>
							<tbody>
					';
					
								while($row = mysqli_fetch_array($result)) {
									echo '
										<tr>
											<td>' . $row['id'] . '</td>
											<td>' . $row['time'] . '</td>
											<td>' . $row['customer_id'] . '</td>
											<td>' . $row['rack_id'] . '</td>
											<td>' . $row['output_id'] . '</td>
											<td>' . $row['total'] . '</td>
											<td>' . $row['subtotal'] . '</td>
										</tr>
									';
								}
					echo '
							</tbody>
						</table>
					';
			
					echo '
						<form class="form-horizontal" action="index.php?group=account&site=list" method="post">
							<input type="hidden" name="stat" id="stat" value="2">	
							<div class="form-group">
								<div class="col-xs-offset-3 col-xs-9 col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2">
									<input type="submit" class="btn btn-primary" value="Generate accounting">
								</div>
							</div>
 						</form>
					';
					break;
				case 2:
					$num = mysqli_num_rows($result);
					$num = $num/2;
					
					for($i=1;$i<=$num;$i++) {
						$sql = "SELECT * FROM use_month WHERE output_id='$i'";
						$result = mysqli_query($db_con,$sql) OR die(mysqli_error($db_con));
						$row = mysqli_fetch_array($result);
						$acc_temp [$i][0] = $row['id'];
						$acc_temp [$i][1] = $row['customer_id'];
						$acc_temp [$i][2] = $row['rack_id'];
						$acc_temp [$i][3] = $row['output_id'];
						$acc_temp [$i][4] = $row['total'];
						$row = mysqli_fetch_array($result);
						$acc_temp [$i][5] = $row['total'];
					}
					
					for($i=1;$i<=$num;$i++) {
						$acc_temp [$i][6] = $acc_temp [$i][5] - $acc_temp [$i][4];
						$acc_temp [$i][7] = '0,33';
					}
					
					echo '
						<table class="table">
							<thead>
								<tr>
									<th rowspan="2">ID</th>
									<th rowspan="2">Customer_ID</th>
									<th rowspan="2">Rack_ID</th>
									<th rowspan="2">Output_ID</th>
									<th rowspan="2">Total_Last</th>
									<th rowspan="2">Total_Now</th>
									<th rowspan="2">consumption</th>
									<th rowspan="2">Price</th>
								</tr>
							</thead>
							<tbody>
					';
					
					for($i=1;$i<=$num;$i++) {
						echo '
										<tr>
											<td>' . $acc_temp [$i][0] . '</td>
											<td>' . $acc_temp [$i][1] . '</td>
											<td>' . $acc_temp [$i][2] . '</td>
											<td>' . $acc_temp [$i][3] . '</td>
											<td>' . $acc_temp [$i][4] . '</td>
											<td>' . $acc_temp [$i][5] . '</td>
											<td>' . $acc_temp [$i][6] . '</td>
											<td>' . $acc_temp [$i][7] . '</td>
										</tr>
									';
					}
					
					echo '
							</tbody>
						</table>
					';
					
					break;
			}
		}else{
			echo '
				<form class="form-horizontal" action="index.php?group=account&site=list" method="post">
					<input type="hidden" name="stat" id="stat" value="1">	
					<div class="form-group">
						<div class="col-xs-offset-3 col-xs-9 col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2">
							<input type="submit" class="btn btn-primary" value="collect informations">
						</div>
					</div>
 				</form>
			';
		}
	}else{

	}

	
?>