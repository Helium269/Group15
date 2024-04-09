<?php
session_start();

// Initialize variables
$error = "";
$passwordError = "";

// Include the database connection script
require_once('admin/db_connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to fetch user from the database based on email
    $sql = "SELECT * FROM userinfo WHERE email='$email'";
    $result = $conn->query($sql);

   // Check if the query was successful
if ($result) {
    // Check if user exists
    if ($result->num_rows == 1) {
        // User found, verify password
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;

            // Redirect to home.php
            header("Location: home.php");
            exit(); // Make sure to exit after redirection
        } else {
            // Password is incorrect
            $passwordError = "Please enter a valid password";
        }
    } else {
        // User not found
        $error = "Invalid email or password";
    }
} else {
    // Error occurred while executing the query
    echo "Error: " . $conn->error;
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
</head>
<style>
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
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
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
            margin-left: auto; /* Move the container to the right */
            margin-right: 20px; /* Add some space between the container and the edge */
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
            color: #4caf50;
            text-decoration: none;
        }

        .options a:hover {
            text-decoration: underline;
        }
        body {
            background-image: url('plane.jpg'); /* Replace 'path_to_your_image.jpg' with the actual path to your image */
            background-size: cover; /* This ensures that the image covers the entire background */
            background-position: center; /* This centers the image */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .container {
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            height: 320px;
            text-align: center;
            margin-right: 10%;
            
        }
        .password-error {
            color: red;
            margin-top: 5px;
            font-size: 14px;
        }

        .error-border {
            border: 1px solid red;
        }
        @media only screen and (max-width: 600px) {
        /* Adjust styles for smaller screens */
        .container {
            width: 90%; /* Make the container wider */
            margin-right: auto; /* Center the container horizontally */
            margin-left: auto; /* Center the container horizontally */
        }
    }

    @media only screen and (max-width: 400px) {
        /* Adjust styles for even smaller screens */
        .container {
            width: 80%; /* Further adjust the width of the container */
        }
    }
    </style>
    
<body>
<div class="logo-container">
        <span class="typing-animation">AeroOptimize</span>
    </div>
    <header>
        <!-- Header content if needed -->
    </header>
    <section class="login">
        <div class="container">
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <?php if (!empty($passwordError)) echo "<p class='password-error'>$passwordError</p>"; ?>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
            <div class="options">
                <a href="signup.php">Signup</a>
                <a href="forgotpw.php">Forgot Password</a>
            </div>
        </div>
    </section>
    <footer>
        <!-- Footer content if needed -->
    </footer>
</body>
</html>
