<?php
	// Get the interface name from the GET request
	$interfaceName = $_GET['interface'];

	// Execute the ip addr show command for the specified interface
	$command = "ip addr show $interfaceName";
	$output = shell_exec("$command 2>&1");

	// Parse the output to get the interface information
	$interface = array();
	$outputLines = explode("\n", $output);
	foreach ($outputLines as $outputLine) {
		if (preg_match('/^\s+inet (\d+\.\d+\.\d+\.\d+)\/(\d+)\s/', $outputLine, $matches)) {
			$ipAddress = $matches[1];
			$netmask = $matches[2];
			$interface['ip_address'] = $ipAddress;
			$interface['netmask'] = $netmask;
		} elseif (preg_match('/^\s+link\/ether (\S+)\s/', $outputLine, $matches)) {
			$macAddress = $matches[1];
			$interface['mac_address'] = $macAddress;
		}
	}

	// Output the interface information as JSON
	header('Content-Type: application/json');
	echo json_encode($interface);
?>
