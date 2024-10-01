<?php
session_start(); // Start the session

// Check if the admin is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Include the database connection
include 'db_connect.php'; 

// Handle actions (add, edit, delete)
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action === 'add_user') {
        $username = $_POST['username'];
        $role = $_POST['role'];
        $email = $_POST['email'];

        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, role, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $role, $email);
        $stmt->execute();
        $stmt->close();
        header('Location: manage_users.php?message=User added');
    } elseif ($action === 'edit_user') {
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $role = $_POST['role'];
        $email = $_POST['email'];

        // Update the user in the database
        $stmt = $conn->prepare("UPDATE users SET username=?, role=?, email=? WHERE id=?");
        $stmt->bind_param("sssi", $username, $role, $email, $user_id);
        $stmt->execute();
        $stmt->close();
        header('Location: manage_users.php?message=User updated');
    } elseif ($action === 'delete_user') {
        $user_id = $_POST['user_id'];

        // Delete the user from the database
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
        header('Location: manage_users.php?message=User deleted');
    }
}

// Fetch all users
$result = $conn->query("SELECT * FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="styles.css"> <!-- Custom styles -->
</head>
<body>

<div class="container">
    <h1>Manage Users</h1>
    
    <!-- Add User Form -->
    <h2>Add New User</h2>
    <form action="manage_users.php" method="POST">
        <input type="hidden" name="action" value="add_user">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="role">Role:</label>
        <select name="role" required>
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
            <option value="parent">Parent</option>
            <option value="nonstaff">Non-Teaching Staff</option>
        </select><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <button type="submit">Add User</button>
    </form>

    <!-- View Users Table -->
    <h2>Users List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['role']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <!-- Edit Button -->
                    <form action="manage_users.php" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="edit_user">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Edit</button>
                    </form>
                    
                    <!-- Delete Button -->
                    <form action="manage_users.php" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="delete_user">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
