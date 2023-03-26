#!/bin/bash

# Get the memory usage information
mem_info=($(free -m | awk 'NR==2{print $3,$2,$7}'))

# Calculate the memory usage percentage
mem_usage=$((${mem_info[0]}*100/${mem_info[1]}))

# Print the memory usage information
echo "Used memory: ${mem_info[0]} MB"
echo "Total memory: ${mem_info[1]} MB"
echo "Memory usage: ${mem_usage}%"
echo "Free memory: ${mem_info[2]} MB"
echo "Free memory percentage: $((100-mem_usage))%"
