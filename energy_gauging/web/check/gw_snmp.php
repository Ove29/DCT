<?php
	function snmp_check ($gw_ip,$gw_com,$gw_ver){
		$check = snmpwalk ($gw_ip, $gw_com, .1.2.6.1.4.1.31034)
	}
?>
