<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email address from the form
    $email = $_POST["email"];
    
    // Generate a random verification code
    $verificationCode = mt_rand(100000, 999999);

    // Example: Send the verification code to the user's email address
    $subject = "Password Reset Verification Code";
    $message = "Your verification code is: $verificationCode";
    $headers = "From: neupanesachet@gmail.com"; // Replace with your email address

    // Send email
    if (mail($email, $subject, $message, $headers)) {
        echo "Verification code sent successfully!";
    } else {
        echo "Failed to send verification code. Please try again later.";
    }
} else {
    // If the form is not submitted, redirect to the forgot password page
    header("Location: forgotpw.php");
    exit();
}
?>
