import subprocess

# Define the path to the file containing the list of malicious devices
malicious_devices_file = "/var/log/malicious_devices.txt"

# Read the list of malicious devices from the file
with open(malicious_devices_file, "r") as f:
    malicious_devices = [line.strip() for line in f]

# Block the malicious devices using firewalld
for device in malicious_devices:
    cmd = ["sudo", "firewall-cmd", "--permanent", "--add-rich-rule='rule family=\"ipv4\" source address=\"{}\" reject'".format(device)]
    subprocess.run(cmd, check=True)

# Reload the firewalld configuration to apply the changes
subprocess.run(["sudo", "firewall-cmd", "--reload"], check=True)
