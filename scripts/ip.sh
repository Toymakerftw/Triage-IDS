ip=$(ifconfig | grep 255.255 | awk '{print $2}')
echo "$ip"  