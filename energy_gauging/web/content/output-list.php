<?php
	include 'db_con.php';

	if(isset($_POST['dp_id'])) {
		$dp_id = $_POST['dp_id'];

		$sql = "SELECT * FROM dp_meter WHERE dp_meter_id='$dp_id'";
		$result = mysqli_query($db_con,$sql) OR die(mysqli_error($db_con));
		$row = mysqli_fetch_array($result);

		echo '<h3>DP-Meter ' . $row['dp_meter_id'] . ' (' . $row['dp_meter_name'] . '):</h3>';

		$sql = "SELECT * FROM output WHERE dp_meter_id='$dp_id'";
                $result = mysqli_query($db_con,$sql) OR die(mysqli_error($db_con));

		echo '
			<table class="table">
				<thead>
					<tr>
						<th>Output ID</th>
						<th>Customer ID</th>
						<th>Rack ID</th>
					</tr>
				</thead>
				<tbody>
		';
					while($row = mysqli_fetch_array($result)){
						echo '<tr>';
							echo '<td>' . $row['output_id'] . '</td>';
							if($row['customer_id']=='0'){
								echo '<td>' . $row['customer_id'] . '</td>';
							}else{
								echo '<td><a href="' . $row['customer_id'] . '" target="_blank">' . $row['customer_id'] . '</a></td>';
							}
							if($row['rack_id']=='0000000'){
								echo '<td class="info">FREE</td>';
							}else{
								echo '<td>' . $row['rack_id'] . '</td>';
							}
						echo '</tr>';
					}
		echo '
				</tbody>
			</table>
		';
	}else{
		$sql = "SELECT * FROM dp_meter";
                $result = mysqli_query($db_con,$sql) OR die(mysqli_error($db_con));

                echo '
                        <form class="form-horizontal" action="index.php?site=show-output" method="post">
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
