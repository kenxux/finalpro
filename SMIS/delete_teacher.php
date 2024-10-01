<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Include the database connection
include 'db_connect.php'; // Adjust the path according to your directory structure

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];

    // Prepare and execute the delete query
    $query = "DELETE FROM teachers WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $teacher_id); // Assuming ID is a string, change to "i" if it's an integer

    if ($stmt->execute()) {
        // Redirect to view teachers page with success message
        header('Location: view_teachers.php?message=Teacher deleted successfully');
    } else {
        // Redirect to view teachers page with error message
        header('Location: view_teachers.php?message=Error deleting teacher: ' . $stmt->error);
    }

    $stmt->close();
} else {
    // If ID is not set, redirect to view teachers page with error message
    header('Location: view_teachers.php?message=No teacher ID specified');
}

$conn->close();
?>
