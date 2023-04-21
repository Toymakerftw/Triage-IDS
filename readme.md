# Triage ~ Network manager & IDS

A Python-based intrusion detection system identifies harmful devices on a network by capturing packet captures and analyzing them with tshark and snort. It utilizes firewalld to prevent these devices from accessing the network and sends notifications to administrators through the Telegram API.

# How does it work ?

- Capture pcap using tshark
- Analyze pcap using Snort to identify malicious devices
- Use firewalld to block malicious devices
- Send alerts to admins using Telegram API
