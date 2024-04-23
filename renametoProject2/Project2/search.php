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
        echo "<div class='container'>";
        echo "<h2>Search Results:</h2>";

        // Initialize variables for tracking cheapest ticket
        $cheapestTicket = null;
        $cheapestPrice = PHP_INT_MAX;
        $allFlights = [];

        // Loop through the query result
        while ($row = $result->fetch_assoc()) {
            // Track cheapest ticket
            if ($row['price'] < $cheapestPrice) {
                $cheapestTicket = $row;
                $cheapestPrice = $row['price'];
            }

            // Store all flights
            $allFlights[] = $row;
        }

        if (isset($_GET['sort'])) {
            if ($_GET['sort'] == 'date') {
                usort($allFlights, function($a, $b) {
                    return strtotime($a['departure_date']) - strtotime($b['departure_date']);
                });
            } elseif ($_GET['sort'] == 'price') {
                usort($allFlights, function($a, $b) {
                    return $a['price'] - $b['price'];
                });
            }
        }

        // Display cheapest ticket
        if ($cheapestTicket) {
            echo "<h3>Cheapest Ticket:</h3>";
            displayFlight($cheapestTicket, true); // Display initially with the cheapest flight flag
            echo "<div class='button-container'>"; // Container for buttons
            echo "<button onclick=\"showAllFlights()\">Show More Flights</button>";
            echo "<button onclick=\"hideAllFlights()\">Hide All Flights</button>";
            echo "<button onclick=\"sortFlights('date')\">Sort by Date</button>";
            echo "<button onclick=\"sortFlights('price')\">Sort by Price</button>";
            echo "</div>";
            echo "<div id='all-flights' style='display: none;'>"; // Hidden container for additional flights
            foreach ($allFlights as $flight) {
                displayFlight($flight, false); // Display all flights without the cheapest flight flag
            }
            echo "</div>";
        }

        echo "</div>"; // Close container
    } else {
        echo "<div class='container'>";
        echo "<h2>No flights found.</h2>";
        echo "</div>"; // Close container
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect to home page if accessed directly without POST request
    header("Location: home.php");
    exit;
}

// Function to display flight information
function displayFlight($flight, $isCheapest) {
    echo "<div class='flight-card'>";
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

    if ($isCheapest) {
        echo "<input type='submit' value='Select & Pay (Cheapest)' class='select-button'>";
    } else {
        echo "<input type='submit' value='Select & Pay' class='select-button'>";
    }

    echo "</form>";

    echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search Results</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('plane.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            position: relative; /* Ensure relative positioning for absolute elements */
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            position: sticky;
            top: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1; /* Ensure buttons overlay on top of other content */
        }

        .flight-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
        }

        .select-button {
            background-color: lightgreen;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .select-button:hover {
            background-color: limegreen;
        }
    </style>
</head>
<body>

<script>
    function showAllFlights() {
        document.getElementById('all-flights').style.display = 'block'; // Show the hidden container
        window.scrollTo(0, 0); // Scroll to the top of the page
    }

    function hideAllFlights() {
        document.getElementById('all-flights').style.display = 'none'; // Hide the container
    }

    function sortFlights(criteria) {
        // Get the search form
        var searchForm = document.getElementById('search-form');

        // Add the sorting criteria to the form
        var sortInput = document.createElement('input');
        sortInput.type = 'hidden';
        sortInput.name = 'sort';
        sortInput.value = criteria;
        searchForm.appendChild(sortInput);

        // Submit the form
        searchForm.submit();
    }
</script>

</body>
</html>
