<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Yusei+Magic&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <style>
        body {
            background-image: url('plane.jpg'); 
            background-size: cover; 
            background-position: center; 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            margin-left: 20px; /* Adjust left margin */
        }

        .logo {
            font-size: 24px;
            margin-right: 10px;
        }

        .typing-animation {
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            font-size: 50px;
            margin-left : 80px;
            font-family: "Yusei Magic", sans-serif;
            font-weight: 400;
            font-style: normal;
            border-right: 3px solid black;
            animation: typing 2s steps(10, end),
                       blink-caret 0.5s step-end infinite alternate;   
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }

        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: black; }
        }

        .container {
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 20%; /* Change width to auto */
    max-width: 90%; /* Set max-width for responsiveness */
    text-align: center;
    margin-left: auto; /* Move container to rightmost part */
    margin-right: 0; /* Remove right margin */
}

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 10px 20px;
            cursor: pointer;
            width: 100%;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .options {
            margin-top: 10px;
        }

        .options a {
            margin-right: 10px;
            color: #00000;
            text-decoration: none;
        }

        .options a:hover {
            text-decoration: underline;
        }

        /* Added CSS for red border */
        .error {
            border: 1px solid red;
        }
    </style>
    
</head>
<?php
session_start();

// Include the database connection script
require_once('admin/db_connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user data from the form
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO userinfo (firstname, lastname, email, phone, password) 
            VALUES ('$firstname', '$lastname', '$email', '$phone', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        // Signup successful, redirect to login page
        header("Location: login.php");
        exit();
    } else {
        // Error occurred while inserting data
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<body>
    <div class="logo-container">
        <span class="typing-animation">AeroOptimize</span>
    </div>

    <div class="container">
        <h2>Signup</h2>
        <form action="signup.php" method="POST" onsubmit="return validateForm()">
            <div class="input-group">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" required>
            </div>
            <div class="input-group">
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="password_confirm">Confirm Password:</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>
            <button type="submit" class="btn">Signup</button>
        </form>
        <div class="options">
            <a href="login.php">Already have an account? Login</a>
        </div>
    </div>

    <script>
        function validateForm() {
            var password = document.getElementById("password");
            var confirmPassword = document.getElementById("password_confirm");

            if (password.value != confirmPassword.value) {
                password.classList.add("error");
                confirmPassword.classList.add("error");
                return false;
            } else {
                password.classList.remove("error");
                confirmPassword.classList.remove("error");
                return true;
            }
        }
    </script>
</body>
</html>
