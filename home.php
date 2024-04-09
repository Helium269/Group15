<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking Homepage</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <header>
        <h1>AeroOptimize</h1>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <section class="search">
        <div class="container">
            <form action="#" method="GET">
            <div class="form-group">
                    <label for="trip-type">Trip Type:</label>
                    <select name="trip-type" id="trip-type">
                        <option value="one-way">One Way</option>
                        <option value="two-way">Two Way</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="origin">Origin:</label>
                    <input type="text" id="origin" name="origin" required>
                </div>
                <div class="form-group">
                    <label for="destination">Destination:</label>
                    <input type="text" id="destination" name="destination" required>
                </div>
                <div class="form-group">
                    <label for="depart-date">Departure Date:</label>
                    <input type="date" id="depart-date" name="depart-date" required>
                </div>
                <div class="form-group" id="return-date-group" style="display:none;">
                    <label for="return-date">Return Date:</label>
                    <input type="date" id="return-date" name="return-date">
                </div>
                <div class="form-group">
                    <label for="passengers">Passengers:</label>
                    <input type="number" id="passengers" name="passengers" min="1" max="10" required>
                </div>
                <button type="submit">Search</button>
            </form>
        </div>
    </section>
    <footer>
        <p>&copy; 2024 Flight Booking. All rights reserved.</p>
    </footer>
</body>
</html>
