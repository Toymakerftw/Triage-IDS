<!DOCTYPE html>
<html>
<head>
	<title>Package Details</title>

	<!-- Include Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!-- Include Font Awesome icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

	<!-- Include header and navbar -->
	<?php include('header.php'); ?>
	<?php include('navbar.php'); ?>

	<!-- Style for package details -->
	<style>
		.package-details {
			margin-top: 50px;
		}

		.package-details h1 {
			margin-bottom: 20px;
		}
	</style>

</head>
<body>

<div class="container package-details">

	<?php
	// Get package name from query string
	$packageName = $_GET['name'];

	// Execute dpkg-query command to get package details
	$command = "dpkg-query -s $packageName";
	$output = shell_exec("$command 2>&1");

	// Parse output to get package details
	$packageDetails = array();
	$outputLines = explode("\n", $output);
	foreach ($outputLines as $outputLine) {
		$outputLine = trim($outputLine);
		if (!empty($outputLine)) {
			$parts = explode(": ", $outputLine);
			$key = $parts[0];
			$value = $parts[1];
			$packageDetails[$key] = $value;
		}
	}

	// Output package details
	echo '<h1>' . $packageDetails['Package'] . '</h1>';
	echo '<table class="table">';
	echo '<tbody>';
	echo '<tr><td>Package:</td><td>' . $packageDetails['Package'] . '</td></tr>';
	echo '<tr><td>Version:</td><td>' . $packageDetails['Version'] . '</td></tr>';
	echo '<tr><td>Status:</td><td>' . $packageDetails['Status'] . '</td></tr>';
	echo '<tr><td>Architecture:</td><td>' . $packageDetails['Architecture'] . '</td></tr>';
	echo '</tbody>';
	echo '</table>';
	?>

	<a href="pkg.php" class="btn btn-secondary"><i class="fas fa-chevron-left"></i> Back to Package Management</a>

</div>

<!-- Include Bootstrap and jQuery JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
