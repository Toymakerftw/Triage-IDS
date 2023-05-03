<?php

// Define Interface
$interface = "enp0s3";

// Define the tcpdump command to capture the pcap file
$tcpdump_cmd = ["sudo", "tcpdump", "-i", $interface, "-w", "/var/log/capture.pcap", "-G", "30", "-W", "1"];

// Start tcpdump to capture the pcap file
$tcpdump_proc = proc_open(implode(" ", $tcpdump_cmd), [], $pipes);

// Wait for tcpdump to capture the pcap file
proc_close($tcpdump_proc);

// Define the Suricata command to analyze the pcap file and identify malicious devices
$suricata_cmd = ["sudo", "suricata", "-r", "/var/log/capture.pcap", "-c", "/etc/suricata/suricata.yaml", "-T", "-l", "/var/log/suricata"];

// Start Suricata to analyze the pcap file
$suricata_proc = proc_open(implode(" ", $suricata_cmd), [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']], $pipes);

// Initialize variable to store malicious devices
$malicious_devices = [];

// Read the output of Suricata to identify malicious devices
while (($line = fgets($pipes[1])) !== false) {
    if (strpos($line, "SRC_IP") !== false) {
        $src_ip = trim(explode(":", $line)[1]);
        if (!in_array($src_ip, $malicious_devices)) {
            $malicious_devices[] = $src_ip;
        }
    }
}

// Initialize variable to store malicious devices' information
$malicious_devices_info = [];

// Find MAC address and hostname of malicious devices using the arp tool
foreach ($malicious_devices as $device) {
    $arp_cmd = ["sudo", "arp", "-n", $device];
    $arp_output = shell_exec(implode(" ", $arp_cmd));
    $mac_address = explode(" ", trim($arp_output))[2];
    $hostname = trim(shell_exec("sudo host $device | awk '{print $NF}'"));
    $malicious_devices_info[] = [$device, $mac_address, $hostname];
}

// Write the malicious devices list to a file
$file_content = "";
foreach ($malicious_devices_info as [$ip, $mac, $hostname]) {
    $file_content .= "$ip $mac $hostname\n";
}
file_put_contents("/var/log/malicious_devices.txt", $file_content);

// Check if any malicious devices were detected and print the appropriate message
if ($malicious_devices_info) {
    echo "Malicious devices detected on the network!\n";
    foreach ($malicious_devices_info as [$ip, $mac, $hostname]) {
        echo "IP: $ip MAC: $mac Hostname: $hostname\n";
    }
} else {
    echo "No malicious devices detected on the network.\n";
}

