<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Include the database connection
include 'db_connect.php'; // Adjust the path according to your directory structure
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Adjust the path to your CSS -->
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Container styling */
        .container {
            max-width: 400px; /* Limit the width of the container */
            margin: 50px auto; /* Center the container and add some vertical space */
            background: #fff; /* White background for the form */
            padding: 20px; /* Add padding inside the container */
            border-radius: 8px; /* Rounded corners for a softer look */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            text-align: center; /* Center text */
        }

        /* Button styling */
        .btn {
            background-color: #007bff; /* Primary color for the button */
            color: white; /* White text for contrast */
            padding: 10px 15px; /* Padding for comfort */
            border: none; /* Remove default border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 16px; /* Larger font for readability */
            margin-top: 15px; /* Add some space above the button */
            display: inline-block; /* Make the button inline-block */
            text-decoration: none; /* Remove underline from links */
            transition: background-color 0.3s; /* Smooth transition for background color */
        }

        /* Button hover effect */
        .btn:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Teachers</h1>

        <a href="add_teacher.php" class="btn">Add Teacher</a>
        <a href="view_teachers.php" class="btn">View Teachers</a>
        <a href="view_teachers.php" class="btn">Edit Teacher</a>
        <a href="delete_teacher.php" class="btn">Delete Teacher</a>
    </div>

    <?php include 'footer.php'; // Include your footer file ?>
</body>
</html>
