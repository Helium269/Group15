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
            margin: 0;
            background-image: url('plane.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            padding: 30px;
            border-radius: 10px;
        }
        h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        p {
            font-size: 24px;
            margin-bottom: 30px;
        }
        .confirmation-message {
            font-size: 18px;
            background-color: rgba(255, 255, 255, 0.5); /* Semi-transparent background for message */
            padding: 15px;
            border-radius: 5px;
        }
        a {
            color: #fff;
            text-decoration: none;
            font-size: 20px;
            border: 2px solid #fff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        a:hover {
            background-color: rgba(255, 255, 255, 0.5);
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Payment Confirmation</h2>
        <p class="confirmation-message"><?php echo isset($payment_confirmation_message) ? $payment_confirmation_message : ''; ?></p>
        <!-- Additional Confirmation Information or Redirect to Another Page -->
        <a href="home.php">Back to Home</a>
    </div>
</body>
</html>
