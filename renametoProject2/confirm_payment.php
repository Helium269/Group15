<?php
// Start the session
session_start();

// Retrieve flight details from POST data
$flight_number = isset($_POST['flight_number']) ? $_POST['flight_number'] : '';
$origin = isset($_POST['origin']) ? $_POST['origin'] : '';
$destination = isset($_POST['destination']) ? $_POST['destination'] : '';
$departure_date = isset($_POST['departure_date']) ? $_POST['departure_date'] : '';
$price = isset($_POST['price']) ? $_POST['price'] : '';
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

// Example payment confirmation logic
$payment_confirmation_message = "Payment Successful!";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
    </style>
</head>
<body>
    <h2>Payment Confirmation</h2>
    <p><?php echo $payment_confirmation_message; ?></p>

   
    <!-- Additional Confirmation Information or Redirect to Another Page -->
</body>
</html>
