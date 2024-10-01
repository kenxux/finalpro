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

// Get the teacher ID from the URL
if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];

    // Fetch teacher data from the database
    $query = "SELECT * FROM teachers WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $teacher = $result->fetch_assoc();
    } else {
        echo "<script>alert('Teacher not found.'); window.location.href='manage_teachers.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No teacher ID selected.'); window.location.href='manage_teachers.php';</script>";
    exit();
}

// Handle form submission for updating teacher data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $hire_date = $_POST['hire_date'];
    $subject = $_POST['subject'];
    $class_assigned = $_POST['class_assigned'];
    $tsc_number = $_POST['tsc_number'];

    // Handling the profile picture upload (if a new picture is uploaded)
    $file_path = $teacher['profile_picture']; // Default to current profile picture

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['profile_picture']['tmp_name'];
        $file_name = $_FILES['profile_picture']['name'];
        $file_path = 'assets/images/profiles/' . basename($file_name);

        // Move the uploaded file to the desired directory
        if (!move_uploaded_file($file_tmp_path, $file_path)) {
            echo "<script>alert('Error uploading the file.');</script>";
            exit();
        }
    }

    // Update the database
    $update_query = "UPDATE teachers SET first_name=?, last_name=?, email=?, phone_number=?, profile_picture=?, hire_date=?, subject=?, class_assigned=?, tsc_number=? WHERE id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssssis", $first_name, $last_name, $email, $phone_number, $file_path, $hire_date, $subject, $class_assigned, $tsc_number, $teacher_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Teacher updated successfully.'); window.location.href='manage_teachers.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
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
        input[type="date"],
        input[type="file"] {
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Teacher</h1>
        <form action="edit_teacher.php?id=<?php echo $teacher_id; ?>" method="POST" enctype="multipart/form-data">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?php echo $teacher['first_name']; ?>" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $teacher['last_name']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $teacher['email']; ?>" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" value="<?php echo $teacher['phone_number']; ?>">

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" name="profile_picture">

            <label for="hire_date">Hire Date:</label>
            <input type="date" name="hire_date" value="<?php echo $teacher['hire_date']; ?>">

            <label for="subject">Subject Taught:</label>
            <input type="text" name="subject" value="<?php echo $teacher['subject']; ?>" required>

            <label for="class_assigned">Class Assigned:</label>
            <input type="text" name="class_assigned" value="<?php echo $teacher['class_assigned']; ?>" required>

            <label for="tsc_number">TSC Number:</label>
            <input type="text" name="tsc_number" value="<?php echo $teacher['tsc_number']; ?>" required>

            <button type="submit">Update Teacher</button>
        </form>
    </div>
    <?php include 'footer.php'; // Include your footer file ?>
</body>
</html>
