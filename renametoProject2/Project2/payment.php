<?php
session_start();

// Retrieve flight information from POST data
$flight_number = isset($_POST['flight_number']) ? $_POST['flight_number'] : '';
$origin = isset($_POST['origin']) ? $_POST['origin'] : '';
$destination = isset($_POST['destination']) ? $_POST['destination'] : '';
$departure_date = isset($_POST['departure_date']) ? $_POST['departure_date'] : '';
$price = isset($_POST['price']) ? $_POST['price']: '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
            background-image: url('plane.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }
        .container {
            max-width: 800px;
            width: 100%;
            padding: 30px;
            text-align: center;
        }
        h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: black;
        }
        h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: black;
        }
        .flight-details {
            text-align: left;
            margin-bottom: 30px;
        }
        .flight-details p {
            margin-bottom: 10px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input[type=text], input[type=number], input[type=email] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Flight Payment</h1>
        <h2>Please review your flight details and select a payment method:</h2>

        <!-- Flight Details Section -->
        <div class="flight-details">
            <h2>Flight Details:</h2>
            <p><strong>Flight Number:</strong> <?php echo $flight_number; ?></p>
            <p><strong>Origin:</strong> <?php echo $origin; ?></p>
            <p><strong>Destination:</strong> <?php echo $destination; ?></p>
            <p><strong>Departure Date:</strong> <?php echo $departure_date; ?></p>
            <p><strong>Price:</strong> $<?php echo $price; ?></p>
        </div>

        <!-- Payment Form -->
        <form method="post" action="confirm_payment.php">
            <input type="hidden" name="flight_number" value="<?php echo $flight_number; ?>">
            <input type="hidden" name="origin" value="<?php echo $origin; ?>">
            <input type="hidden" name="destination" value="<?php echo $destination; ?>">
            <input type="hidden" name="departure_date" value="<?php echo $departure_date; ?>">
            <input type="hidden" name="price" value="<?php echo $price; ?>">

            <h2>Select Payment Method:</h2>
            <label><input type="radio" name="payment_method" value="card"> Pay by Card</label><br>
            <label><input type="radio" name="payment_method" value="paypal"> Pay with PayPal</label><br>
            <label><input type="radio" name="payment_method" value="bank_transfer"> Bank Transfer</label><br>

            <!-- Card Payment Form -->
            <div id="card-form" class="payment-form" style="display: none;">
                <h2>Card Payment Details:</h2>
                <input type="text" name="card_number" placeholder="Card Number" required><br>
                <input type="text" name="expiry_date" placeholder="Expiry Date (MM/YYYY)" required><br>
                <input type="text" name="cvv" placeholder="CVV" required><br>
                <input type="text" name="cardholder_name" placeholder="Cardholder Name" required><br>
            </div>

            <!-- PayPal Payment Form -->
            <div id="paypal-form" class="payment-form" style="display: none;">
                <h2>PayPal Details:</h2>
                <p>Please enter your PayPal account email:</p>
                <input type="email" name="paypal_email" placeholder="PayPal Email" required><br>
            </div>

            <!-- Bank Transfer Payment Form -->
            <div id="bank_transfer-form" class="payment-form" style="display: none;">
                <h2>Bank Transfer Details:</h2>
                <p>Please enter your bank account details:</p>
                <input type="text" name="bank_name" placeholder="Bank Name" required><br>
                <input type="text" name="account_number" placeholder="Account Number" required><br>
                <input type="text" name="routing_number" placeholder="Routing Number" required><br>
            </div>

            <!-- Submit Button -->
	<a href="confirm_payment.php">Confirm Payment</a>
    </form>
    </div>

    <script>
        // Function to show the selected payment form based on the radio button
        document.querySelectorAll('input[name="payment_method"]').forEach((elem) => {
            elem.addEventListener("change", function(event) {
                document.querySelectorAll('.payment-form').forEach((form) => {
                    form.style.display = 'none';
                });
                const selectedForm = document.getElementById(event.target.value + '-form');
                if (selectedForm) {
                    selectedForm.style.display = 'block';
                }
            });
        });
    </script>
</body>
</html>
