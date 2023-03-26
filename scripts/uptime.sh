upSeconds="$(/usr/bin/cut -d. -f1 /proc/uptime)"
mins=$((upSeconds / 60 % 60))
hours=$((upSeconds / 3600 % 24))
printf "%02d hrs %02d mins\n" "$hours" "$mins"
