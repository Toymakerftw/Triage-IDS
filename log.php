<!DOCTYPE html>
<html>
<head>
	<title>Download Logs</title>
	
	<!-- Include Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!-- Include Font Awesome icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

	<?php
	include('header.php');
	include('navbar.php');
	?>

</head>
<body>
	<div class="container mt-5">
		<h1>Download Logs</h1>
		<div class="list-group">
			<?php
			// Set the path to the logs directory
			$logsDirectory = '/var/log/';

			// Get a list of all log files in the directory
			$logFiles = scandir($logsDirectory);

			// Loop through each log file and display its details
			foreach ($logFiles as $logFile) {
				// Ignore hidden files and directories
				if ($logFile[0] == '.') {
					continue;
				}

				// Set the file path and name
				$filePath = $logsDirectory . $logFile;
				$fileName = basename($filePath);

				// Determine file type based on file extension
				$fileType = '';
				$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
				switch ($fileExtension) {
					case 'log':
						$fileType = 'fa-file-alt';
						break;
					case 'txt':
						$fileType = 'fa-file-alt';
						break;
					case 'pdf':
						$fileType = 'fa-file-pdf';
						break;
					case 'doc':
					case 'docx':
						$fileType = 'fa-file-word';
						break;
					case 'xls':
					case 'xlsx':
						$fileType = 'fa-file-excel';
						break;
					default:
						$fileType = 'fa-file';
				}

				// Output the file details and download buttons
				echo '<div class="d-flex justify-content-between align-items-center list-group-item list-group-item-action">';
				echo '<div><i class="fas ' . $fileType . ' mr-2"></i>' . $fileName . ' (' . round(filesize($filePath) / 1024, 2) . ' KB)</div>';
				echo '<div><a href="download.php?file=' . urlencode($fileName) . '" class="btn btn-sm btn-primary mr-2"><i class="fas fa-download"></i> Download</a><a href="view.php?file=' . urlencode($fileName) . '" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> View Online</a></div>';
				echo '</div>';
			}
			?>
		</div>
	</div>

	<!-- Include Bootstrap and jQuery JS -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
