<?php
session_start(); // Start a session to access session variables

// Check if the user is logged in; if not, redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to the login page
    exit(); // Stop executing the script
}

// Include the database connection
include 'db_connect.php'; // Adjust the path according to your directory structure
include 'header.php'; // Include the header file for consistent layout

// Handle form submission when the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs
    $first_name = htmlspecialchars(trim($_POST['first_name'])); // First name
    $last_name = htmlspecialchars(trim($_POST['last_name'])); // Last name
    $middle_name = htmlspecialchars(trim($_POST['middle_name'])); // Middle name (optional)
    $dob = $_POST['dob']; // Date of birth
    $gender = $_POST['gender']; // Gender
    $email = htmlspecialchars(trim($_POST['email'])); // Email (unique)
    $phone_number = htmlspecialchars(trim($_POST['phone_number'])); // Phone number
    $address = htmlspecialchars(trim($_POST['address'])); // Home address
    $nationality = htmlspecialchars(trim($_POST['nationality'])); // Nationality
    $enrollment_date = $_POST['enrollment_date']; // Enrollment date
    $class_assigned = htmlspecialchars(trim($_POST['class_assigned'])); // Assigned class or grade
    $parent_guardian_name = htmlspecialchars(trim($_POST['parent_guardian_name'])); // Name of parent/guardian
    $parent_guardian_contact = htmlspecialchars(trim($_POST['parent_guardian_contact'])); // Contact number of parent/guardian
    $admission_number = htmlspecialchars(trim($_POST['admission_number'])); // Unique admission number
    
    // Handle profile picture upload (optional)
    $file_path = null; // Initialize variable for file path
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        // Check if a file is uploaded without errors
        $file_tmp_path = $_FILES['profile_picture']['tmp_name']; // Temporary file path
        $file_name = $_FILES['profile_picture']['name']; // Original file name
        $file_path = 'assets/images/profiles/' . basename($file_name); // Define the target file path

        // Move the uploaded file to the specified directory
        if (!move_uploaded_file($file_tmp_path, $file_path)) {
            echo "<script>alert('Error uploading the file.');</script>"; // Alert on failure
            exit(); // Stop executing the script
        }
    }

    // Prepare the SQL INSERT statement to add the new student to the database
    $insert_query = "INSERT INTO students (first_name, last_name, middle_name, dob, gender, email, phone_number, address, nationality, enrollment_date, class_assigned, profile_picture, parent_guardian_name, parent_guardian_contact, admission_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare the statement for execution
    $stmt = $conn->prepare($insert_query);
    
    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind the parameters to the SQL query
        $stmt->bind_param("sssssssssssssss", $first_name, $last_name, $middle_name, $dob, $gender, $email, $phone_number, $address, $nationality, $enrollment_date, $class_assigned, $file_path, $parent_guardian_name, $parent_guardian_contact, $admission_number);
        
        // Execute the prepared statement
        if ($stmt->execute()) {
            // Alert and redirect on successful insertion
            echo "<script>alert('Student added successfully.'); window.location.href='view_students.php';</script>";
        } else {
            // Alert on execution error
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Alert if the statement preparation failed
        echo "<script>alert('Error preparing statement.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Set character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive design -->
    <title>Add Student</title> <!-- Page title -->
    <link rel="stylesheet" href="../assets/style.css"> <!-- Include your CSS file for styling -->
    <style>
        /* Inline CSS for styling the form */
        body {
            font-family: Arial, sans-serif; /* Set font style */
            background-color: #f4f4f4; /* Set background color */
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
        }
        
        .container {
            max-width: 600px; /* Set max width for the container */
            margin: 50px auto; /* Center the container with margin */
            background: #fff; /* White background for the container */
            padding: 20px; /* Padding around the container */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
        }

        h1 {
            text-align: center; /* Center align the heading */
            color: #333; /* Heading color */
        }

        label {
            display: block; /* Block display for labels */
            margin: 15px 0 5px; /* Margin for labels */
            font-weight: bold; /* Bold font for labels */
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="file"],
        select {
            width: 100%; /* Full width for inputs */
            padding: 10px; /* Padding inside inputs */
            border: 1px solid #ccc; /* Border color for inputs */
            border-radius: 4px; /* Rounded corners for inputs */
            box-sizing: border-box; /* Box sizing model */
            transition: border-color 0.3s; /* Transition for border color */
        }

        input:focus {
            border-color: #007bff; /* Change border color on focus */
            outline: none; /* Remove outline */
        }

        button {
            background-color: #007bff; /* Button background color */
            color: white; /* Button text color */
            padding: 10px 15px; /* Padding for button */
            border: none; /* Remove border */
            border-radius: 4px; /* Rounded corners for button */
            cursor: pointer; /* Change cursor to pointer */
            font-size: 16px; /* Font size for button text */
            margin-top: 15px; /* Margin on top of button */
            transition: background-color 0.3s; /* Transition for background color */
        }

        button:hover {
            background-color: #0056b3; /* Darker background on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add a Student</h1> <!-- Page heading -->
        <form action="add_student.php" method="POST" enctype="multipart/form-data"> <!-- Form for adding a student -->
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" required> <!-- Input for first name -->

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" required> <!-- Input for last name -->

            <label for="middle_name">Middle Name:</label>
            <input type="text" name="middle_name"> <!-- Input for middle name (optional) -->

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" required> <!-- Input for date of birth -->

            <label for="gender">Gender:</label>
            <select name="gender" required> <!-- Dropdown for gender selection -->
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="email">Email:</label>
            <input type="email" name="email" required> <!-- Input for email -->

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" required> <!-- Input for phone number -->

            <label for="address">Address:</label>
            <input type="text" name="address"> <!-- Input for home address -->

            <label for="nationality">Nationality:</label>
            <input type="text" name="nationality"> <!-- Input for nationality -->

            <label for="enrollment_date">Enrollment Date:</label>
            <input type="date" name="enrollment_date" required> <!-- Input for enrollment date -->

            <label for="class_assigned">Class Assigned:</label>
            <input type="text" name="class_assigned" required> <!-- Input for assigned class -->

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" name="profile_picture"> <!-- Input for profile picture upload -->

            <label for="parent_guardian_name">Parent/Guardian Name:</label>
            <input type="text" name="parent_guardian_name" required> <!-- Input for parent/guardian name -->

            <label for="parent_guardian_contact">Parent/Guardian Contact:</label>
            <input type="text" name="parent_guardian_contact" required> <!-- Input for parent/guardian contact -->

            <label for="admission_number">Admission Number:</label>
            <input type="text" name="admission_number" required> <!-- Input for admission number -->

            <button type="submit">Add Student</button> <!-- Submit button -->
        </form>
    </div>
</body>
</html>
