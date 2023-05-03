<?php

// Load the pcap file
$pcapFilePath = __DIR__ . '/file.pcap'; // Assumes the pcap file is saved as 'file.pcap' in the same directory as the script
$pcapData = file_get_contents($pcapFilePath);

// Extract features from the pcap file using tshark
$featuresFilePath = __DIR__ . '/features.csv'; // Change this to the path of your features file
exec("tshark -r $pcapFilePath -T fields -E separator=, -E quote=d -e ip.src -e ip.dst -e tcp.srcport -e tcp.dstport -e udp.srcport -e udp.dstport > $featuresFilePath");

// Load the pre-trained model
$modelFilePath = __DIR__ . '/model.pkl'; // Change this to the path of your model file
$model = joblib_load($modelFilePath); // Assumes you have scikit-learn installed and can use joblib_load function

// Preprocess the data
// You may need to scale or normalize the data, convert categorical variables
// to numerical ones, and so on, depending on the specific model and features used
$features = load_csv($featuresFilePath); // Assumes you have a load_csv function that can load a CSV file

// Make predictions
$predictions = $model->predict($features); // Assumes your model is capable of making predictions on an input

// Evaluate the results
// You can output the predictions, or compare them to ground-truth labels (if available)
// to evaluate the performance of the model
if (in_array(1, $predictions)) {
    echo "Malicious Activity detected\n";

    // Use Suricata to detect and list malicious devices
    exec("suricata -r $pcapFilePath -c suricata.yaml --list-matches > /dev/null 2>&1");

    // Load the list of malicious devices
    $maliciousDevicesFilePath = __DIR__ . '/malicious_devices.txt'; // Change this to the path of your malicious devices file
    $maliciousDevices = file($maliciousDevicesFilePath, FILE_IGNORE_NEW_LINES);

    // Generate an HTML table to display the list of malicious devices
    echo "<html><head><title>Malicious Devices</title></head><body>";
    echo "<h1>Malicious Devices</h1>";
    echo "<table><tr><th>IP Address</th><th>MAC Address</th></tr>";
    foreach ($maliciousDevices as $device) {
        list($ip, $mac) = explode(",", $device);
        echo "<tr><td>$ip</td><td>$mac</td></tr>";
    }
    echo "</table></body></html>";
}

// Function to load a CSV file and return its contents as a 2D array
function load_csv($filePath) {
    $csvData = array_map('str_getcsv', file($filePath));
    array_walk($csvData, function(&$row) use ($csvData) {
        $row = array_combine($csvData[0], $row);
    });
    array_shift($csvData);
    return $csvData;
}

?>
