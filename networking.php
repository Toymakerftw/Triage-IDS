<!DOCTYPE html>
<html>

<head>
    <title>Network Interfaces</title>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Font Awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <?php
		include('header.php');
		include('navbar.php');
	?>

    <div class="container mt-5">
        <h1>Network Interfaces</h1>
        <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th>Interface Name</th>
                    <th>IP Address</th>
                    <th>Netmask</th>
                    <th>MAC Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
    // Execute ip addr show command to get network interface information
    $command = 'ip addr show';
    $output = shell_exec("$command 2>&1");

    // Parse output to get list of network interfaces and their information
    $interfaces = array();
    $outputLines = explode("\n", $output);
    foreach ($outputLines as $outputLine) {
        if (preg_match('/^\d+:\s+(\S+):\s+.+$/', $outputLine, $matches)) {
            $interfaceName = $matches[1];
            $interfaces[$interfaceName] = array();
        } elseif (preg_match('/^\s+inet (\d+\.\d+\.\d+\.\d+)\/(\d+)\s/', $outputLine, $matches)) {
            $ipAddress = $matches[1];
            $netmask = $matches[2];
            $interfaces[$interfaceName]['ip_address'] = $ipAddress;
            $interfaces[$interfaceName]['netmask'] = $netmask;
        } elseif (preg_match('/^\s+link\/ether (\S+)\s/', $outputLine, $matches)) {
            $macAddress = $matches[1];
            $interfaces[$interfaceName]['mac_address'] = $macAddress;
        }
    }

    // Output list of network interfaces and their information
    foreach ($interfaces as $interfaceName => $interface) {
        echo '<tr>';
        echo '<td>' . $interfaceName . '</td>';
        echo '<td>' . (isset($interface['ip_address']) ? $interface['ip_address'] : '') . '</td>';
        echo '<td>' . (isset($interface['netmask']) ? $interface['netmask'] : '') . '</td>';
        echo '<td>' . (isset($interface['mac_address']) ? $interface['mac_address'] : '') . '</td>';
        echo '<td><button class="btn btn-primary" onclick="refreshInterface(\'' . $interfaceName . '\')">Refresh</button></td>';
        echo '</tr>';
    }
?>
            </tbody>
        </table>
    </div>



    <!-- Include Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="refresh_interface.js"></script>

    </body>

</html>