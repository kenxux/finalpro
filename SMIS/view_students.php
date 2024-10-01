<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Include the database connection
include 'db_connect.php'; // Adjust the path according to your directory structure

// Fetch students from the database
$query = "SELECT * FROM students"; // Adjust table name as necessary
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
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
            max-width: 800px; /* Limit the width of the container */
            margin: 50px auto; /* Center the container and add some vertical space */
            background: #fff; /* White background for the form */
            padding: 20px; /* Add padding inside the container */
            border-radius: 8px; /* Rounded corners for a softer look */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        /* Table styling */
        table {
            width: 100%; /* Full width for the table */
            border-collapse: collapse; /* Remove spacing between table cells */
        }

        th, td {
            padding: 10px; /* Padding for table cells */
            text-align: left; /* Left-align text */
            border-bottom: 1px solid #ccc; /* Add border below rows */
        }

        th {
            background-color: #007bff; /* Header background color */
            color: white; /* Header text color */
        }

        tr:hover {
            background-color: #f1f1f1; /* Highlight row on hover */
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
            text-decoration: none; /* Remove underline from links */
            transition: background-color 0.3s; /* Smooth transition for background color */
        }

        /* Button hover effect */
        .btn:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
        .button {
            background-color: #007bff; /* Primary color for buttons */
            color: white; /* White text for contrast */
            padding: 10px 15px; /* Padding for comfort */
            border: none; /* Remove default border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 16px; /* Larger font for readability */
            margin: 5px; /* Space between buttons */
            transition: background-color 0.3s; /* Smooth transition for background color */
        }

        /* Button hover effect */
        .button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>View Students</h1>
        <a href="add_student.php" class="button">Add a Student</a> <!-- Button to add a new teacher -->

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($student = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['first_name']; ?></td>
                            <td><?php echo $student['last_name']; ?></td>
                            <td><?php echo $student['email']; ?></td>
                            <td><?php echo $student['phone_number']; ?></td>
                            <td>
                                <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="btn">Edit</a>
                                <a href="delete_student.php?id=<?php echo $student['id']; ?>" class="btn">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No students found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; // Include your footer file ?>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
