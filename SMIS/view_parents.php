<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if the user is not logged in
    exit();
}

// Include the database connection
include 'db_connect.php'; // Adjust the path to your database connection file

// Fetch all parent records from the database along with their associated student data
$query = "
    SELECT parents.*, students.first_name AS student_first_name, students.last_name AS student_last_name 
    FROM parents 
    LEFT JOIN students ON parents.admission_number = students.admission_number
";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Parents</title>
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
            width: 90%;
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

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        /* Button styling */
        .btn {
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 5px;
        }

        /* Button hover effect */
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>View Parents</h1>

        <!-- Check if there are any parent records to display -->
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Relationship</th>
                        <th>Address</th>
                        <th>Occupation</th>
                        <th>Student Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through each parent record and display it in the table -->
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['first_name']; ?></td>
                            <td><?php echo $row['last_name']; ?></td>
                            <td><?php echo $row['phone_number']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['relationship']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['occupation']; ?></td>
                            <td><?php echo $row['student_first_name'] . ' ' . $row['student_last_name']; ?></td>
                            <td>
                                <a href="edit_parent.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                                <a href="delete_parent.php?id=<?php echo $row['id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this parent?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No parents found.</p>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; // Include the footer ?>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
