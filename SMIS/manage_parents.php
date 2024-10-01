<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit(); // Stop script execution after the redirect
}

// Include the database connection
include 'db_connect.php'; // Adjust the path to your db_connect file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Parents</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Link to your CSS file -->
    <style>
        /* General styling for the body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Container styling for the buttons and page layout */
        .container {
            max-width: 600px; /* Set a max width for the page */
            margin: 50px auto; /* Center the container */
            background: #fff; /* White background */
            padding: 20px; /* Add padding inside the container */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            text-align: center; /* Center-align text */
        }

        /* Button styling for each action */
        .btn {
            background-color: #007bff; /* Set button color to blue */
            color: white; /* White text for contrast */
            padding: 10px 15px; /* Padding inside buttons */
            border: none; /* Remove default border */
            border-radius: 4px; /* Rounded corners for the button */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 16px; /* Larger text for readability */
            margin-top: 15px; /* Space above the buttons */
            display: inline-block; /* Make the buttons inline-block */
            text-decoration: none; /* Remove underlines from links */
            transition: background-color 0.3s; /* Smooth background color transition */
        }

        /* Hover effect for buttons */
        .btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Parents</h1> <!-- Page heading -->

        <!-- Links to different management actions -->
        <a href="add_parent.php" class="btn">Add Parent</a> <!-- Button to add a new parent -->
        <a href="view_parents.php" class="btn">View Parents</a> <!-- Button to view all parents -->
        <a href="edit_parent.php" class="btn">Edit Parent</a> <!-- Button to edit a parent -->
        <a href="delete_parent.php" class="btn">Delete Parent</a> <!-- Button to delete a parent -->
    </div>

    <?php include 'footer.php'; // Include the footer file ?>
</body>
</html>
