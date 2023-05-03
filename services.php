<!DOCTYPE html>
<html>
<head>
	<title>Service Status</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<?php
include('header.php');
include('navbar.php');
?>

<div class="container mt-5">
	<h1>Service Status</h1>
	<table class="table mt-5">
		<thead>
			<tr>
				<th>Service</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Execute service command to list services and their statuses
			$command = 'service --status-all';
			$output = shell_exec("$command 2>&1");

			// Parse output to get service names and statuses
			$services = array();
			$outputLines = explode("\n", $output);
			foreach ($outputLines as $outputLine) {
				if (!empty($outputLine)) {
					$statusChar = substr($outputLine, 3, 1);
					$serviceName = trim(substr($outputLine, 5));
					switch ($statusChar) {
						case '+':
							$status = 'running';
							break;
						case '-':
							$status = 'stopped';
							break;
						case '?':
							$status = 'unknown';
							break;
						default:
							$status = 'unrecognized';
							break;
					}
					$services[] = array('name' => substr($serviceName, 1), 'status' => $status);
				}
			}

			// Output table of service names, statuses, and actions
			foreach ($services as $service) {
				echo '<tr>';
				echo '<td>' . $service['name'] . '</td>';
				echo '<td><span class="badge badge-pill badge-' . ($service['status'] == 'running' ? 'success' : 'danger') . '">' . $service['status'] . '</span></td>';
				echo '<td class="align-middle">';
				if ($service['status'] == 'running') {
					echo '<form action="service_actions.php" method="post" class="d-inline-block">';
					echo '<input type="hidden" name="action" value="stop">';
					echo '<input type="hidden" name="service_name" value="' . $service['name'] . '">';
					echo '<button type="submit" class="btn btn-danger">Stop</button>';
					echo '</form>';
					echo '<form action="service_actions.php" method="post" class="d-inline-block ml-2">';
					echo '<input type="hidden" name="action" value="restart">';
					echo '<input type="hidden" name="service_name" value="' . $service['name'] . '">';
					echo '<button type="submit" class="btn btn-primary">Restart</button>';
					echo '</form>';
				} else {
					echo '<form action="service_actions.php" method="post" class="d-inline-block">';
					echo '<input type="hidden" name="action" value="start">';
					echo '<input type="hidden" name="service_name" value="' . $service['name'] . '">';
					echo '<button type="submit" class="btn btn-success">Start</button>';
                    echo '</form>';
                }
                echo '</td>';
                echo '</tr>';
            }			?>
		</tbody>
	</table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
