<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Include the database connection
include 'db_connect.php'; // Adjust the path to your database connection file

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $relationship = $_POST['relationship'];
    $address = $_POST['address'];
    $occupation = $_POST['occupation'];
    $admission_number = $_POST['admission_number'];

    // Check for existing admission_number
    $check_query = "SELECT * FROM parents WHERE admission_number = ? OR email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ss", $admission_number, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Admission number or email already exists
        $existing_entries = [];
        while ($row = $result->fetch_assoc()) {
            if ($row['admission_number'] === $admission_number) {
                $existing_entries[] = "Admission number already exists.";
            }
            if ($row['email'] === $email) {
                $existing_entries[] = "Email already exists.";
            }
        }
        echo "<script>alert('Error: " . implode(" ", $existing_entries) . " Please use different values.'); window.location.href='add_parent.php';</script>";
    } else {
        // Prepare the insert query
        $insert_query = "INSERT INTO parents (first_name, last_name, phone_number, email, relationship, address, occupation, admission_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssssssss", $first_name, $last_name, $phone_number, $email, $relationship, $address, $occupation, $admission_number);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Parent added successfully.'); window.location.href='manage_parents.php';</script>";
        } else {
            echo "<script>alert('Error adding parent: " . $stmt->error . "'); window.location.href='add_parent.php';</script>";
        }
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Parent</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Link to your CSS file -->
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
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Heading styling */
        h1 {
            text-align: center;
            color: #333;
        }

        /* Label styling */
        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }

        /* Input field styling */
        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        /* Input field focus effect */
        input:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Button styling */
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        /* Button hover effect */
        button:hover {
            background-color: #0056b3;
        }
       .footer{
        margin-bottom: -150px;
       }        
    </style>
</head>
<body>
    <div class="container">
        <h1>Add a Parent</h1> <!-- Page heading -->
        <form action="add_parent.php" method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" required> <!-- Parent's first name input field -->

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" required> <!-- Parent's last name input field -->

            <label for="phone_number">Phone Number:</label>
            <input type="tel" name="phone_number" id="phone_number" required> <!-- Parent's phone number input field -->

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required> <!-- Parent's email input field -->

            <label for="relationship">Relationship to Student:</label>
            <input type="text" name="relationship" id="relationship" required> <!-- Relationship to student input field -->

            <label for="address">Address:</label>
            <input type="text" name="address" id="address"> <!-- Address input field (optional) -->

            <label for="occupation">Occupation:</label>
            <input type="text" name="occupation" id="occupation"> <!-- Occupation input field (optional) -->

            <label for="admission_number">Admission Number:</label>
            <input type="text" name="admission_number" required>

            <button type="submit">Add Parent</button> <!-- Submit button to add the parent -->
        </form>
    </div>

    <?php include 'footer.php'; // Include the footer file ?>
</body>
</html>
