<?php
// Check if term is set in $_GET array
if (isset($_GET['term'])) {
    // Get user input
    $input = $_GET['term'];
    // Get selected "From" airport code if available
    $selectedFrom = isset($_GET['from']) ? $_GET['from'] : null;

    // Load airport data from JSON file
    $airportData = file_get_contents('airports.json');
    $jsonData = json_decode($airportData, true);

    // Check if JSON data is properly loaded and contains airport data
    if (is_array($jsonData) && isset($jsonData[2]['data'])) {
        // Extract airport data
        $airportArray = $jsonData[2]['data'];

        // Filter airports based on user input and selected "From" airport
        $suggestions = [];
        foreach ($airportArray as $airport) {
            // Check if all expected keys exist in the airport data
            if (isset($airport['name'], $airport['cityName'], $airport['countryName'])) {
                if (($selectedFrom && $airport['code'] !== $selectedFrom) || !$selectedFrom) {
                    if (stripos($airport['name'], $input) !== false || 
                        stripos($airport['cityName'], $input) !== false ||
                        stripos($airport['countryName'], $input) !== false) {
                        $suggestions[] = $airport;
                    }
                }
            }
        }

        // Return suggestions as JSON
        echo json_encode($suggestions);
    } else {
        echo 'No airport data found.';
    }
} else {
    echo 'No input provided.';
}
?>
