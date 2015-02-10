<?php
	function ping_it($gw_ip) {
 		exec("ping -c 1 $gw_ip", $array, $return);
		// system("ping -c 1 $gw_ip", $return);
		return $return;
	}
?>
