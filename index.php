<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking Homepage</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#from, #to").on("input", function() {
                var inputVal = $(this).val();
                var inputField = $(this); // Store reference to the input element
                var fieldId = inputField.attr("id"); // Get the ID of the input field
                if (inputVal.length) {
                    $.ajax({
                        url: "get_airports.php",
                        type: "GET",
                        dataType: "json",
                        data: {term: inputVal}, // Pass the input field ID as a parameter
                        success: function(response) {
                            // Clear previous suggestions for this input field
                            inputField.siblings(".suggestions").remove();
                            // Create a new list for suggestions for this input field
                            var suggestionsList = $("<ul class='suggestions'></ul>");
                            // Append each suggestion to the list
                            $.each(response, function(index, airport) {
                                var option = $("<li>" + airport.name + ", " + airport.cityName + ", " + airport.countryName + "</li>");
                                // Set the value of the option to the airport code
                                option.attr("value", airport.code);
                                suggestionsList.append(option);
                            });
                            // Display the suggestions below the input field
                            inputField.after(suggestionsList);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    // If the input is empty, remove any previous suggestions for this input field
                    inputField.siblings(".suggestions").remove();
                }
            });

            // Handle selection of an airport option
            $(document).on("click", ".suggestions li", function() {
                var selectedAirportName = $(this).text();
                var selectedAirportCode = $(this).attr("value");
                // Set the input field value to the selected airport name
                $(this).closest(".container").find("input").val(selectedAirportName);
                // Optionally, you can store the selected airport code for further processing
                // e.g., $(this).closest(".container").find("input").attr("data-airport-code", selectedAirportCode);
                // Remove the suggestions list for this input field
                $(this).closest(".suggestions").remove();
            });
        });
    </script>
    <style>
        body {
            background-image: url('your-image.jpg');
            background-size: cover; /* Adjust as needed */
            background-repeat: no-repeat; /* Adjust as needed */
            background-position: center; /* Adjust as needed */
        }
    </style>
</head>
<body>
    <header>
        <button id="login-button" onclick="window.location.href='login.php';">Login</button>
        <h1>AeroOptimize</h1>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact</a></li>
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
                    <label for="from">From:</label>
                    <input type="text" id="from" name="from" placeholder="From" required>
                </div>
                <div class="form-group">
                    <label for="to">To:</label>
                    <input type="text" id="to" name="to" placeholder="To" required>
                </div>
                <div class="form-group" id="return-date-group" style="display:none;">
                    <label for="return-date">Return Date:</label>
                    <input type="date" id="return-date" name="return-date">
                </div>
                <div class="form-group">
                    <label for="depart-date">Departure Date:</label>
                    <input type="date" id="depart-date" name="depart-date
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
        <div class="container">
            <p>&copy; 2024 Flight Booking. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
