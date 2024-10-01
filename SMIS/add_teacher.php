<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Include the database connection
include 'db_connect.php'; // Adjust the path according to your directory structure
include 'header.php'; // Include your header file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $hire_date = $_POST['hire_date'];
    $subject = $_POST['subject'];
    $class_assigned = $_POST['class_assigned'];
    $tsc_number = $_POST['tsc_number']; // New field for TSC number

    // Handling the profile picture upload
    $file_path = 'default_profile_picture.jpg'; // Fallback profile picture

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['profile_picture']['tmp_name'];
        $file_name = $_FILES['profile_picture']['name'];
        $file_path = 'assets/images/profiles/' . basename($file_name);

        // Move the uploaded file to the desired directory
        if (!move_uploaded_file($file_tmp_path, $file_path)) {
            echo "<div style='color: green; background-color: orange; text-align: center; padding: 10px;'>Error uploading the file.</div>";
            exit();
        }
    }

    // Check if any of the credentials already exist
    $checkQuery = "SELECT * FROM teachers WHERE email = ? OR phone_number = ? OR tsc_number = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("sss", $email, $phone_number, $tsc_number);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<div style='color: green; background-color: orange; text-align: center; padding: 10px;'>Error: The email, phone number, or TSC number is already in use. Please use different credentials.</div>";
    } else {
        // Proceed with the insertion if no duplicates are found
        $query = "INSERT INTO teachers (first_name, last_name, email, phone_number, profile_picture, hire_date, subject, class_assigned, tsc_number) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssss", $first_name, $last_name, $email, $phone_number, $file_path, $hire_date, $subject, $class_assigned, $tsc_number);
        
        if ($stmt->execute()) {
            echo "<div style='color: green; background-color: orange; text-align: center; padding: 10px;'>Teacher added successfully.</div>";
        } else {
            echo "<div style='color: green; background-color: orange; text-align: center; padding: 10px;'>Error: " . $stmt->error . "</div>";
        }
        
        $stmt->close();
    }

    $checkStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Adjust the path to your CSS -->
    <style>
        /* Your existing styles here */
        /* General body styling */
        body {
            font-family: Arial, sans-serif; /* Set a clean, modern font */
            background-color: #f4f4f4; /* Light background color for contrast */
            margin: 0; /* Remove default margins */
            padding: 0; /* Remove default padding */
        }

        /* Container styling */
        .container {
            max-width: 600px; /* Limit the width of the container */
            margin: 50px auto; /* Center the container and add some vertical space */
            background: #fff; /* White background for the form */
            padding: 20px; /* Add padding inside the container */
            border-radius: 8px; /* Rounded corners for a softer look */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        /* Heading styling */
        h1 {
            text-align: center; /* Center the heading */
            color: #333; /* Darker text color for contrast */
        }

        /* Label styling */
        label {
            display: block; /* Labels should be block elements for spacing */
            margin: 15px 0 5px; /* Add top margin for spacing */
            font-weight: bold; /* Bold font for emphasis */
        }

        /* Input field styling */
        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="file"] {
            width: 100%; /* Full width for inputs */
            padding: 10px; /* Padding for comfort */
            border: 1px solid #ccc; /* Light border */
            border-radius: 4px; /* Slightly rounded corners */
            box-sizing: border-box; /* Include padding in width calculation */
            transition: border-color 0.3s; /* Smooth transition for border color */
        }

        /* Input field focus effect */
        input:focus {
            border-color: #007bff; /* Change border color on focus */
            outline: none; /* Remove default outline */
        }

        /* Button styling */
        button {
            background-color: #007bff; /* Primary color for the button */
            color: white; /* White text for contrast */
            padding: 10px 15px; /* Padding for comfort */
            border: none; /* Remove default border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 16px; /* Larger font for readability */
            margin-top: 15px; /* Add some space above the button */
            transition: background-color 0.3s; /* Smooth transition for background color */
        }

        /* Button hover effect */
        button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Add a Teacher</h1>
        <form action="add_teacher.php" method="POST" enctype="multipart/form-data">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" required>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" name="profile_picture">

            <label for="hire_date">Hire Date:</label>
            <input type="date" name="hire_date">

            <label for="subject">Subject Taught:</label>
            <input type="text" name="subject" required>

            <label for="class_assigned">Class Assigned:</label>
            <select name="class_assigned" required>
                <option value="">Select Class</option>
                <option value="Class 1">Class 1</option>
                <option value="Class 2">Class 2</option>
                <option value="Class 3">Class 3</option>
                <option value="Class 4">Class 4</option>
                <option value="Class 5">Class 5</option>
                <option value="Class 6">Class 6</option>
                <option value="Class 7">Class 7</option>
                <option value="Class 8">Class 8</option>
                <option value="Form 1">Form 1</option>
                <option value="Form 2">Form 2</option>
                <option value="Form 3">Form 3</option>
                <option value="Form 4">Form 4</option>
            </select>

            <label for="tsc_number">TSC Number:</label>
            <input type="VARCHAR" name="tsc_number" required> <!-- New TSC number field -->

            <button type="submit">Add Teacher</button>
        </form>
    </div>
</body>
</html>
