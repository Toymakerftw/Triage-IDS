<!DOCTYPE html>
<html>
<head>
	<title>Package Manager</title>

	<!-- Include Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!-- Include Font Awesome icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

	<?php
	include('header.php');
	include('navbar.php');

	// Check if form has been submitted
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Check which button was clicked
		if (isset($_POST['install'])) {
			// Get package name from form
			$packageName = $_POST['packageName'];

			// Execute apt-get command to install package
			$command = "sudo apt-get install -y $packageName";
			$output = shell_exec("$command 2>&1");

			// Show installation progress to user
			echo '<div class="container mt-5">';
			echo '<h1>Install Package</h1>';
			echo '<h2>Installing ' . $packageName . '...</h2>';
			echo '<pre>' . $output . '</pre>';
			echo '</div>';
		} elseif (isset($_POST['remove'])) {
			// Get package name from form
			$packageName = $_POST['packageName'];

			// Execute apt-get command to remove package
			$command = "sudo apt-get remove -y $packageName";
			$output = shell_exec("$command 2>&1");

			// Show removal progress to user
			echo '<div class="container mt-5">';
			echo '<h1>Remove Package</h1>';
			echo '<h2>Removing ' . $packageName . '...</h2>';
			echo '<pre>' . $output . '</pre>';
			echo '</div>';
		}
	}
?>
<div class="container mt-5">
	<h1>Package Management</h1>
	<div class="row mt-5">
		<div class="col-md-6">
			<h2>Installed Packages</h2>
			<div class="list-group">
				<?php
				// Execute dpkg command to list installed packages
				$command = 'dpkg --get-selections';
				$output = shell_exec("$command 2>&1");

				// Parse output to get package names
				$packages = array();
				$outputLines = explode("\n", $output);
				foreach ($outputLines as $outputLine) {
					$outputLine = trim($outputLine);
					if (!empty($outputLine)) {
						$parts = explode("\t", $outputLine);
						$packageName = $parts[0];
						$packages[] = $packageName;
					}
				}

				// Output list of installed packages
				foreach ($packages as $packageName) {
					echo '<div class="list-group-item d-flex justify-content-between align-items-center">' . $packageName 
					. '<a href="package_details.php?name=' . $packageName . '" class="btn btn-primary btn-sm">View Details</a></div>';
				}
								?>
			</div>
		</div>
		<div class="col-md-6">
			<h2>Install or Remove Package</h2>
			<form method="post">
				<div class="form-group">
					<label for="packageName">Package Name:</label>
					<input type="text" class="form-control" id="packageName" name="packageName" required>
				</div>
				<button type="submit" class="btn btn-primary" name="install">Install Package</button>
				<button type="submit" class="btn btn-danger" name="remove">Remove Package</button>
			</form>
		</div>
	</div>
</div>

	<!-- Include Bootstrap and jQuery JS -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
