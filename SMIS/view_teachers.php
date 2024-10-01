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

// Query to fetch teachers
$query = "SELECT * FROM teachers"; // Adjust this query as needed
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Teachers</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Adjust the path to your CSS -->
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif; /* Set a clean, modern font */
            background-color: #f4f4f4; /* Light background color for contrast */
            margin: 0; /* Remove default margins */
            padding: 0; /* Remove default padding */
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

        /* Heading styling */
        h1 {
            text-align: center; /* Center the heading */
            color: #333; /* Darker text color for contrast */
        }

        /* Table styling */
        table {
            width: 100%; /* Full width for the table */
            border-collapse: collapse; /* Remove double borders */
            margin-top: 20px; /* Add some space above the table */
        }

        th, td {
            border: 1px solid #ccc; /* Light border */
            padding: 10px; /* Padding for comfort */
            text-align: left; /* Left align text */
        }

        th {
            background-color: #007bff; /* Header background color */
            color: white; /* Header text color */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for even rows */
        }

        tr:hover {
            background-color: #e0e0e0; /* Hover effect for rows */
        }

        /* Button styling */
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
        .footer{
            margin-bottom: -220px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>View Teachers</h1>

        <a href="add_teacher.php" class="button">Add a Teacher</a> <!-- Button to add a new teacher -->

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                <?php while ($teacher = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($teacher['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($teacher['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($teacher['email']); ?></td>
                        <td>
                            <a href="edit_teacher.php?id=<?php echo $teacher['id']; ?>" class="button">Edit</a> <!-- Edit button -->
                            <a href="delete_teacher.php?id=<?php echo $teacher['id']; ?>" class="button" onclick="return confirm('Are you sure you want to delete this teacher?');">Delete</a> <!-- Delete button -->
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No teachers found.</p>
        <?php endif; ?>

    </div>
    <?php include 'footer.php'; // Include your footer file ?>
</body>
</html>

<?php
$conn->close();
?>
