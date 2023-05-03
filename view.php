<!DOCTYPE html>
<html>
<head>
	<title>View Log File</title>
	<!-- Include Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<!-- Include Font Awesome icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

	<?php
	include('header.php');
	include('navbar.php');
	?>

</head>
<body>
	<div class="container mt-5">
		<h1>View Log File</h1>
		<a href="log.php" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Back</a>
		<?php
		// Get the requested file name from the URL
		if (!isset($_GET['file'])) {
			echo '<div class="alert alert-danger">No log file specified.</div>';
			exit();
		}
		$fileName = $_GET['file'];

		// Set the path to the logs directory
		$logsDirectory = '/var/log/';

		// Set the file path
		$filePath = $logsDirectory . $fileName;

		// Check if the file exists
		if (!file_exists($filePath)) {
			echo '<div class="alert alert-danger">Log file not found.</div>';
			exit();
		}

		// Read the file contents
		$fileContents = file_get_contents($filePath);

		// Output the file contents in a preformatted block
		echo '<pre>' . htmlspecialchars($fileContents) . '</pre>';
		?>
	</div>

	<!-- Include Bootstrap and jQuery JS -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
