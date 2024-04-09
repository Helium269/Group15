<?php
// Start the session
session_start();

// Determine absolute path to db_connect.php using __DIR__
require_once('db_connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve search parameters from the form
    $trip_type = $_POST['trip_type'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $depart_date = $_POST['depart_date'];
    $return_date = isset($_POST['return_date']) ? $_POST['return_date'] : null;
    $passengers = $_POST['passengers'];

    // Define date range for searching close departure dates
    $date_range_start = date('Y-m-d', strtotime($depart_date . ' -3 days')); // 3 days before depart_date
    $date_range_end = date('Y-m-d', strtotime($depart_date . ' +3 days')); // 3 days after depart_date

    // Construct SQL query based on search parameters
    $sql = "SELECT * FROM flights 
            WHERE origin = '$origin' 
            AND destination = '$destination'
            AND departure_date BETWEEN '$date_range_start' AND '$date_range_end'
            ORDER BY departure_date"; // Order by departure_date for close dates

    // Execute the query
    $result = $conn->query($sql);

    // Display search results
    if ($result->num_rows > 0) {
        echo "<h2>Search Results:</h2>";

        // Initialize variables for tracking cheapest ticket and exact matched date
        $cheapestTicket = null;
        $cheapestPrice = PHP_INT_MAX;
        $exactMatchedFlights = [];

        // Loop through the query result
        while ($row = $result->fetch_assoc()) {
            // Check for exact matched departure date
            if ($row['departure_date'] == $depart_date) {
                $exactMatchedFlights[] = $row;
            }

            // Track cheapest ticket
            if ($row['price'] < $cheapestPrice) {
                $cheapestTicket = $row;
                $cheapestPrice = $row['price'];
            }
        }

        // Display flights with exact matched departure date on top
        if (!empty($exactMatchedFlights)) {
            echo "<h3>Exact Matched Departure Date:</h3>";
            foreach ($exactMatchedFlights as $flight) {
                displayFlight($flight, $cheapestTicket);
            }
        }

        // Display cheapest ticket
        if ($cheapestTicket) {
            echo "<h3>Cheapest Ticket:</h3>";
            displayFlight($cheapestTicket, $cheapestTicket);
        }
    } else {
        echo "No flights found.";
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect to home page if accessed directly without POST request
    header("Location: home.php");
    exit;
}

// Function to display flight information
function displayFlight($flight, $cheapestTicket) {
    echo "<div style='border: 1px solid black; padding: 10px; margin: 10px;'>";
    echo "<b>Flight Number:</b> " . $flight['flight_number'] . "<br>";
    echo "<b>Origin:</b> " . $flight['origin'] . "<br>";
    echo "<b>Destination:</b> " . $flight['destination'] . "<br>";
    echo "<b>Departure Date:</b> " . $flight['departure_date'] . "<br>";
    echo "<b>Return Date:</b> " . $flight['return_date'] . "<br>";
    echo "<b>Available Seats:</b> " . $flight['available_seats'] . "<br>";
    echo "<b>Price:</b> $" . $flight['price'] . "<br>";

    // Create a link/button to select the flight and proceed to payment page
    echo "<form action='payment.php' method='post'>";
    echo "<input type='hidden' name='flight_number' value='" . $flight['flight_number'] . "'>";
    echo "<input type='hidden' name='origin' value='" . $flight['origin'] . "'>";
    echo "<input type='hidden' name='destination' value='" . $flight['destination'] . "'>";
    echo "<input type='hidden' name='departure_date' value='" . $flight['departure_date'] . "'>";
    echo "<input type='hidden' name='price' value='" . $flight['price'] . "'>";

    // Highlight cheapest ticket
    if ($cheapestTicket && $flight['price'] == $cheapestTicket['price']) {
        echo "<input type='submit' value='Select & Pay (Cheapest)' style='background-color: lightgreen;'>";
    } else {
        echo "<input type='submit' value='Select & Pay'>";
    }

    echo "</form>";

    echo "</div>";
}
?>
