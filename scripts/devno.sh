#!/bin/bash

# Use arp to get the list of devices on the network
devices=$(arp -a | awk '!/incomplete/{print $1}' | sort -u)

# Count the number of devices found
num_devices=$(echo "$devices" | wc -l)

# Print the number of devices found
echo "$num_devices"
