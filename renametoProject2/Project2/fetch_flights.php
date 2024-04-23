<?php
// Include database connection and any necessary functions
require_once('db_connect.php');

// Retrieve search parameters from the GET request
$origin = $_GET['origin'];
$destination = $_GET['destination'];
$departDate = $_GET['departDate'];

// Define date range for searching close departure dates
$date_range_start = date('Y-m-d', strtotime($departDate . ' -3 days')); // 3 days before departDate
$date_range_end = date('Y-m-d', strtotime($departDate . ' +3 days')); // 3 days after departDate

// Construct SQL query to fetch more flights based on search criteria
$sql = "SELECT * FROM flights 
        WHERE origin = '$origin' 
        AND destination = '$destination'
        AND departure_date BETWEEN '$date_range_start' AND '$date_range_end'
        ORDER BY departure_date";

// Execute the query
$result = $conn->query($sql);

$flightsData = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $flightsData[] = $row;
    }
}

// Close the database connection
$conn->close();

// Output flights data as JSON
header('Content-Type: application/json');
echo json_encode($flightsData);
?>
