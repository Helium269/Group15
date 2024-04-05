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
    // Function to handle input in the "From" field and show autocomplete suggestions
    $("#from").on("input", function() {
        var inputVal = $(this).val();
        var suggestionsList = $("#from-suggestions");

        if (inputVal.length) {
            $.ajax({
                url: "get_airports.php",
                type: "GET",
                dataType: "json",
                data: {term: inputVal},
                success: function(response) {
                    suggestionsList.empty();
                    $.each(response, function(index, airport) {
                        var option = $("<li>" + airport.name + "</li>");
                        suggestionsList.append(option);
                    });
                    suggestionsList.show(); // Show the suggestions dropdown
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            suggestionsList.hide(); // Hide the suggestions dropdown when input is empty
        }
    });

    // Handle selection of an airport option
    $("#from-suggestions").on("click", "li", function() {
        var selectedAirportName = $(this).text();
        $("#from").val(selectedAirportName);
        $("#from-suggestions").hide(); // Hide the suggestions dropdown after selection
    });

    // Function to toggle visibility of return date based on trip type
    $("#trip-type").on("change", function() {
        var tripType = $(this).val();
        if (tripType === "one-way") {
            $("#return-date-group").hide();
        } else if (tripType === "two-way") {
            $("#return-date-group").show();
            // Ensure return date is after departure date
            var departureDate = new Date($("#depart-date").val());
            var returnDate = new Date($("#return-date").val());
            if (returnDate < departureDate) {
                $("#return-date").val(""); // Clear return date if it's before departure date
            }
        }
    });

    // Validate return date when it's changed
    $("#return-date").on("change", function() {
        var departureDate = new Date($("#depart-date").val());
        var returnDate = new Date($(this).val());
        if (returnDate < departureDate) {
            alert("Return date must be after departure date.");
            $(this).val(""); // Clear return date if it's before departure date
        }
    });
});

    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            color: #fff;
            padding: 10px 0;
            text-align: center;
            width: 100%;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 10px;
        }

        .search {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('your-image.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            padding: 20px;
            position: relative; /* Ensure relative positioning for proper placement of suggestions dropdown */
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            height: auto;
        }

        footer {
            color: #fff;
            text-align: center;
            padding: 10px 0;
            width: 100%;
        }

        .suggestions {
    position: absolute;
    top: calc(100% + 5px); /* Position the dropdown below the input field */
    left: 0;
    z-index: 1000;
    background-color: #fff;
    border: 1px solid #ccc;
    border-top: none;
    width: calc(100% - 2px); /* Make the dropdown width same as the input field */
    max-height: 200px; /* Limit the maximum height of the dropdown */
    overflow-y: auto; /* Add scrollbar when the content exceeds the max-height */
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.suggestions li {
    padding: 5px;
    cursor: pointer;
}

.suggestions li:hover {
    background-color: #f2f2f2;
}


        input[type="text"],
        input[type="date"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }
    </style>
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
                    <!-- Suggestions dropdown for "From" field -->
                    <ul id="from-suggestions" class="suggestions"></ul>
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
                    <input type="date" id="depart-date" name="depart-date" required>
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
