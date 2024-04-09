<?php
session_start();

// Retrieve flight information from POST data
$flight_number = isset($_POST['flight_number']) ? $_POST['flight_number'] : '';
$origin = isset($_POST['origin']) ? $_POST['origin'] : '';
$destination = isset($_POST['destination']) ? $_POST['destination'] : '';
$departure_date = isset($_POST['departure_date']) ? $_POST['departure_date'] : '';
$price = isset($_POST['price']) ? $_POST['price'] : '';


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
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        input[type=text], input[type=number], input[type=email] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
        .payment-form {
            display: none; /* Hide all payment forms initially */
        }
    </style>
    <script>
        // Function to show the selected payment form based on the radio button
        function showPaymentForm(paymentMethod) {
            // Hide all payment forms
            var paymentForms = document.getElementsByClassName('payment-form');
            for (var i = 0; i < paymentForms.length; i++) {
                paymentForms[i].style.display = 'none';
            }

            // Show the selected payment form
            var selectedForm = document.getElementById(paymentMethod + '-form');
            if (selectedForm) {
                selectedForm.style.display = 'block';
            }
        }
    </script>
</head>
<body>
    <h2>Flight Payment</h2>
    <p>Please review your flight details and select a payment method:</p>

    <!-- Display Flight Details -->
    <div>
        <h3>Flight Details:</h3>
        <p><strong>Flight Number:</strong> <?php echo $flight_number; ?></p>
        <p><strong>Origin:</strong> <?php echo $origin; ?></p>
        <p><strong>Destination:</strong> <?php echo $destination; ?></p>
        <p><strong>Departure Date:</strong> <?php echo $departure_date; ?></p>
        <p><strong>Price:</strong> $<?php echo $price; ?></p>
    </div>

    <!-- Payment Options -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="flight_number" value="<?php echo $flight_number; ?>">
        <input type="hidden" name="origin" value="<?php echo $origin; ?>">
        <input type="hidden" name="destination" value="<?php echo $destination; ?>">
        <input type="hidden" name="departure_date" value="<?php echo $departure_date; ?>">
        <input type="hidden" name="price" value="<?php echo $price; ?>">

        <h3>Select Payment Method:</h3>
        <label><input type="radio" name="payment_method" value="card" onclick="showPaymentForm('card')"> Pay by Card</label><br>
        <label><input type="radio" name="payment_method" value="paypal" onclick="showPaymentForm('paypal')"> Pay with PayPal</label><br>
        <label><input type="radio" name="payment_method" value="bank_transfer" onclick="showPaymentForm('bank_transfer')"> Bank Transfer</label><br>

        <!-- Card Payment Form -->
        <div id="card-form" class="payment-form">
            <h3>Card Payment Details:</h3>
            <input type="text" name="card_number" placeholder="Card Number" required><br>
            <input type="text" name="expiry_date" placeholder="Expiry Date (MM/YYYY)" required><br>
            <input type="text" name="cvv" placeholder="CVV" required><br>
            <input type="text" name="cardholder_name" placeholder="Cardholder Name" required><br>
        </div>

        <!-- PayPal Payment Form -->
        <div id="paypal-form" class="payment-form">
            <h3>PayPal Details:</h3>
            <p>Please enter your PayPal account email:</p>
            <input type="email" name="paypal_email" placeholder="PayPal Email" required><br>
        </div>

        <!-- Bank Transfer Payment Form -->
        <div id="bank_transfer-form" class="payment-form">
            <h3>Bank Transfer Details:</h3>
            <p>Please enter your bank account details:</p>
            <label for="bank_name">Bank Name:</label>
            <input type="text" name="bank_name" placeholder="Bank Name" required><br>
            <label for="account_number">Account Number:</label>
            <input type="text" name="account_number" placeholder="Account Number" required><br>
            <label for="routing_number">Routing Number:</label>
            <input type="text" name="routing_number" placeholder="Routing Number" required><br>
        </div>

        <!-- Confirm Payment Link -->
        <a href="confirm_payment.php">Confirm Payment</a>
    </form>

</body>
</html>
