<!-- File: teacher.php -->
<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Include database connection
include 'db_connect.php'; // Adjust the path as necessary
include 'header.php'; // Adjust the path as necessary

// Fetch teachers from the database
$query = "SELECT * FROM teachers"; // Modify as necessary based on your database structure
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers - School Management System</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Adjust the path as necessary -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
</head>
<body>
    <div class="dashboard-container">
        <nav class="sidebar" id="sidebar">
            <!-- Sidebar content goes here, similar to admin_dashboard.php -->
        </nav>

        <div class="main-content">
            <h1>Manage Teachers</h1>

            <div class="actions">
                <a href="add_teacher.php" class="btn"><i class="fas fa-plus" title="Add Teacher"></i></a>
                <a href="edit_teacher.php" class="btn"><i class="fas fa-edit" title="Edit Teacher"></i></a>
                <a href="delete_teacher.php" class="btn"><i class="fas fa-trash" title="Delete Teacher"></i></a>
                <a href="view_teacher.php" class="btn"><i class="fas fa-eye" title="View Teachers"></i></a>
            </div>

            <h2>Teacher List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                            echo "<td><a href='edit_teacher.php?id=" . htmlspecialchars($row['id']) . "' class='btn'><i class='fas fa-edit' title='Edit'></i></a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No teachers found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include footer -->
    <?php include 'footer.php'; ?> <!-- Adjust the path as necessary -->
</body>
</html>
