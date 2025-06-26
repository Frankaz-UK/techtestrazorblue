<?php
// Task 3
$filename = 'technical-test-data.csv';
$data = array();
$uniqueVehicles = array();

if (($handle = fopen($filename, 'r')) !== false) {
    $headers = fgetcsv($handle);

    while (($row = fgetcsv($handle)) !== false) {
        $rowData = array_combine($headers, $row);
        $reg = $rowData['Car Registration'];

        if (!isset($uniqueVehicles[$reg])) {
            $uniqueVehicles[$reg] = $rowData;
        }
    }

    fclose($handle);
}

$data = array_values($uniqueVehicles);

// Group by fuel type and write CSVs
$fuelTypes = array();

foreach ($data as $vehicle) {
    $fuel = $vehicle['Fuel'];

    if (!isset($fuelTypes[$fuel])) {
        $fuelTypes[$fuel] = array();
    }

    $fuelTypes[$fuel][] = $vehicle;
}

foreach ($fuelTypes as $fuel => $vehicles) {
    $filename = 'export_' . preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($fuel)) . '.csv';
    $fp = fopen($filename, 'w');
    fputcsv($fp, array_keys($vehicles[0]));

    foreach ($vehicles as $v) {
        fputcsv($fp, $v);
    }

    fclose($fp);
}

// Valid registration pattern: Two letters, two numbers, space, three letters
const REGEX_VALID_REG = '/^[A-Z]{2}[0-9]{2} [A-Z]{3}$/i';
$validVehicles = array();
$invalidCount = 0;

foreach ($data as $vehicle) {
    $reg = $vehicle['Car Registration'];

    if (preg_match(REGEX_VALID_REG, $reg)) {
        $validVehicles[] = $vehicle;
    } else {
        $invalidCount++;
    }
}

// Output valid registrations
$validFile = 'valid_registrations.csv';
$fp = fopen($validFile, 'w');

if (!empty($validVehicles)) {
    fputcsv($fp, array_keys($validVehicles[0]));

    foreach ($validVehicles as $v) {
        fputcsv($fp, $v);
    }
}

fclose($fp);

// Output invalid registration count
echo "Invalid registration count: $invalidCount\n";
?>