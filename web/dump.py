import subprocess

# Define the tcpdump command to capture the pcap file
tcpdump_cmd = ["sudo", "tcpdump", "-i", "eth0", "-w", "/var/log/capture.pcap", "-G", "600", "-W", "1"]

# Start tcpdump to capture the pcap file
tcpdump_proc = subprocess.Popen(tcpdump_cmd)

# Wait for tcpdump to capture the pcap file
tcpdump_proc.wait()

# Define the Suricata command to analyze the pcap file and identify malicious devices
suricata_cmd = ["sudo", "suricata", "-r", "/var/log/capture.pcap", "-c", "/etc/suricata/suricata.yaml", "-T", "-l", "/var/log/suricata"]

# Start Suricata to analyze the pcap file
suricata_proc = subprocess.Popen(suricata_cmd, stdout=subprocess.PIPE)

# Initialize variable to store malicious devices
malicious_devices = []

# Read the output of Suricata to identify malicious devices
for line in suricata_proc.stdout:
    if b"SRC_IP" in line:
        src_ip = line.strip().split(b":")[1].decode("utf-8").strip()
        if src_ip not in malicious_devices:
            malicious_devices.append(src_ip)

# Write the malicious devices list to a file
with open("/var/log/malicious_devices.txt", "w") as f:
    f.write("\n".join(malicious_devices))

# Check if any malicious devices were detected and print the appropriate message
if malicious_devices:
    print("Malicious devices detected on the network! Check /var/log/malicious_devices.txt for details.")
else:
    print("No malicious devices detected on the network.")
