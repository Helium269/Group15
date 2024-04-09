<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search Results</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <header>
        <h1>AeroOptimize - Search Results</h1>
        <!-- Navigation menu if needed -->
    </header>
    <section class="search-results">
        <div class="container">
            <?php
            session_start(); // Start the session if not already started

            // Check if search results are stored in session
            if (isset($_SESSION['search_results']) && !empty($_SESSION['search_results'])) {
                $search_results = $_SESSION['search_results'];
                echo "<h2>Search Results:</h2>";
                echo "<ul>";
                foreach ($search_results as $flight) {
                    echo "<li>Origin: {$flight['origin']} | Destination: {$flight['destination']} | Departure Date: {$flight['departure_date']}</li>";
                }
                echo "</ul>";
            } else {
                // No search results found
                echo "<p>No flights found for the specified criteria.</p>";
            }

            // Clear search results from session
            unset($_SESSION['search_results']);
            ?>
        </div>
    </section>
    <footer>
        <p>&copy; 2024 Flight Booking. All rights reserved.</p>
    </footer>
</body>
</html>
