import subprocess
from flask import Flask, render_template, request

# Define the path to the file containing the list of malicious devices
malicious_devices_file = "/var/log/malicious_devices.txt"

app = Flask(__name__)

def block_devices(devices):
    """
    Blocks a list of devices using firewalld
    """
    for device in devices:
        # Check if device is already blocked
        cmd = ["sudo", "firewall-cmd", "--list-rich-rules"]
        output = subprocess.run(cmd, check=True, capture_output=True, text=True).stdout
        if f"source address=\"{device}\"" in output:
            continue
        # Block device
        cmd = ["sudo", "firewall-cmd", "--permanent", f"--add-rich-rule='rule family=\"ipv4\" source address=\"{device}\" reject'"]
        subprocess.run(cmd, check=True)

    # Reload the firewalld configuration to apply the changes
    subprocess.run(["sudo", "firewall-cmd", "--reload"], check=True)

def unblock_device(device):
    """
    Unblocks a device using firewalld
    """
    cmd = ["sudo", "firewall-cmd", "--permanent", f"--remove-rich-rule='rule family=\"ipv4\" source address=\"{device}\" reject'"]
    subprocess.run(cmd, check=True)

    # Reload the firewalld configuration to apply the changes
    subprocess.run(["sudo", "firewall-cmd", "--reload"], check=True)

def view_blocked_devices():
    """
    Views a list of devices currently blocked by firewalld
    """
    cmd = ["sudo", "firewall-cmd", "--list-rich-rules"]
    output = subprocess.run(cmd, check=True, capture_output=True, text=True).stdout
    blocked_devices = []
    for line in output.split("\n"):
        if "source address" in line:
            device = line.split("=")[1].strip('"')
            blocked_devices.append(device)
    return blocked_devices

@app.route("/", methods=["GET", "POST"])
def index():
    if request.method == "POST":
        if request.form.get("action") == "block":
            device = request.form.get("device")
            block_devices([device])
        elif request.form.get("action") == "unblock":
            device = request.form.get("device")
            unblock_device(device)
    blocked_devices = view_blocked_devices()
    return render_template("index.html", blocked_devices=blocked_devices)

# Read the list of malicious devices from the file
with open(malicious_devices_file, "r") as f:
    malicious_devices = [line.strip() for line in f]

# Block the malicious devices using firewalld
block_devices(malicious_devices)

if __name__ == "__main__":
    app.run()
