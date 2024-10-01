<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Include the database connection
include 'db_connect.php'; // Adjust the path to your database connection file

// Check if the parent ID is set in the URL
if (isset($_GET['id'])) {
    $parent_id = $_GET['id'];

    // Prepare the delete query using the correct table name
    $delete_query = "DELETE FROM parents WHERE admission_number = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("s", $parent_id); // Assuming admission_number is a string

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Parent deleted successfully.'); window.location.href='manage_parents.php';</script>";
    } else {
        echo "<script>alert('Error deleting parent: " . $stmt->error . "'); window.location.href='manage_parents.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('No parent ID selected.'); window.location.href='manage_parents.php';</script>";
}

// Close the database connection
$conn->close();
?>
