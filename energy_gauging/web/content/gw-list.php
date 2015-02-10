<?php
	include 'db_con.php';
	
	$sql = "SELECT * FROM gateway";
	$result = mysqli_query($db_con,$sql) OR die(mysqli_error($db_con));
	
	echo '
		<table class="table">
			<thead>
				<tr>
					<th rowspan="2">ID</th>
					<th rowspan="2">Name</th>
					<th rowspan="2">IP</th>
					<th colspan="2">SNMP</th>
					<th rowspan="2">Location</th>
					<th rowspan="2">Description</th>
					<th rowspan="2"></th>
				</tr>
				<tr>
					<th>Version</th>
					<th>Community</th>
				</tr>
			</thead>
			<tbody>
	';
				while($row = mysqli_fetch_array($result)) {
					echo '
						<tr>
							<td>' . $row['gw_id'] . '</td>
							<td>' . $row['gw_name'] . '</td>
							<td>' . $row['gw_ip'] . '</td>
							<td>' . $row['gw_snmp_version'] . '</td>
							<td>' . $row['gw_snmp_community'] . '</td>
							<td>' . $row['gw_location'] . '</td>
							<td>' . $row['gw_description'] . '</td>
							<td>' . '<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Edit </button>' . '</td>
						</tr>
					';
				}
	echo '
			</tbody>
		</table>
	';
?>