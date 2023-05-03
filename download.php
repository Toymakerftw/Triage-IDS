<?php
// Get the filename from the query string
$fileName = $_GET['file'];

// Set the path to the logs directory
$logsDirectory = '/var/log/';

// Set the full path to the file
$filePath = $logsDirectory . $fileName;

// Check if the file exists
if (!file_exists($filePath)) {
    die('File not found');
}

// Set the headers to force download of the file
header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Content-Length: ' . filesize($filePath));
header('Pragma: no-cache');
header('Expires: 0');

// Output the file contents
readfile($filePath);
