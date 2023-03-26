#!/bin/bash

# Get the local IP address
ip=$(ip addr show | grep 'inet ' | awk '{print $2}' | cut -f1 -d'/')

# Use ARP to get the list of devices on the network
arp=$(arp -a | grep -v incomplete | awk '{print $2}' | cut -d'(' -f2 | cut -d')' -f1)

# Print the list of devices
printf '%s\n' "${arp[@]}"
