<!-- File: login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School Management System</title>
    <link rel="stylesheet" href="assets/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="login-container">
        <h2 style="color: orangered;" >Login</h2>
        <form action="login.php" method="POST">
            <label style="color: blue;" for="username">Username:</label>
            <input type="text" id="username" name="username" autocomplete="username" required><br><br> <!-- Added autocomplete -->
            <label style="color: blue;" for="password">Password:</label>
            <input type="password" id="password" name="password" autocomplete="current-password" required><br><br> <!-- Added autocomplete -->
            <button type="submit" name="login">Login</button>
        </form>
        <?php
        session_start();
        include 'db_connect.php';

        // Handle login form submission
      // Check if the form is submitted by checking if 'login' is present in the POST data
if (isset($_POST['login'])) {
    
    // Retrieve the username from the POST request and sanitize it to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']); // Sanitize input

    // Retrieve the password from the POST request and sanitize it to prevent SQL injection
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Sanitize input

    // Prepare the SQL query to check if the user exists in the database
    // The password is hashed using SHA-256 for security
    $query = "SELECT * FROM users WHERE username='$username' AND password=SHA2('$password', 256)";
    
    // Execute the SQL query against the database
    $result = mysqli_query($conn, $query);

    // Check if any row is returned (indicating successful login)
    if (mysqli_num_rows($result) == 1) {
        
        // Store the username in session variables for later use
        $_SESSION['username'] = $username;

        // Redirect the user to the admin dashboard
        header("Location: index.php");
        
        // Stop further script execution to ensure the redirect happens
        exit(); // Ensure script stops after redirect
    } else {
        // If login fails, display an error message to the user
        echo "<p style='color:red;'>Invalid credentials!</p>"; // Error message for invalid login
    }
}

        ?>
    </div>
</body>
</html>
