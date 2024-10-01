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

// Get the student ID from the URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch student data from the database
    $query = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();
    } else {
        echo "<script>alert('Student not found.'); window.location.href='manage_students.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No student ID selected.'); window.location.href='manage_students.php';</script>";
    exit();
}

// Handle form submission for updating student data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $middle_name = $_POST['middle_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $nationality = $_POST['nationality'];
    $enrollment_date = $_POST['enrollment_date'];
    $class_assigned = $_POST['class_assigned'];
    $profile_picture = $student['profile_picture']; // Default to current profile picture

    // Handling the profile picture upload (if a new picture is uploaded)
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['profile_picture']['tmp_name'];
        $file_name = $_FILES['profile_picture']['name'];
        $profile_picture = 'assets/images/profiles/' . basename($file_name);

        // Move the uploaded file to the desired directory
        if (!move_uploaded_file($file_tmp_path, $profile_picture)) {
            echo "<script>alert('Error uploading the file.');</script>";
            exit();
        }
    }

    // Update the database
    $update_query = "UPDATE students SET first_name=?, last_name=?, middle_name=?, dob=?, gender=?, email=?, phone_number=?, address=?, nationality=?, enrollment_date=?, class_assigned=?, profile_picture=? WHERE id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssssssssi", $first_name, $last_name, $middle_name, $dob, $gender, $email, $phone_number, $address, $nationality, $enrollment_date, $class_assigned, $profile_picture, $student_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Student updated successfully.'); window.location.href='manage_students.php';</script>";
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
    <title>Edit Student</title>
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
        input[type="file"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        /* Input field focus effect */
        input:focus,
        select:focus {
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
        .footer {
            margin-bottom: -450px;          
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Student</h1>
        <form action="edit_student.php?id=<?php echo $student_id; ?>" method="POST" enctype="multipart/form-data">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?php echo $student['first_name']; ?>" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $student['last_name']; ?>" required>

            <label for="middle_name">Middle Name:</label>
            <input type="text" name="middle_name" value="<?php echo $student['middle_name']; ?>">

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" value="<?php echo $student['dob']; ?>" required>

            <label for="gender">Gender:</label>
            <select name="gender" required>
                <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo ($student['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $student['email']; ?>" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" value="<?php echo $student['phone_number']; ?>">

            <label for="address">Address:</label>
            <input type="text" name="address" value="<?php echo $student['address']; ?>">

            <label for="nationality">Nationality:</label>
            <input type="text" name="nationality" value="<?php echo $student['nationality']; ?>">

            <label for="enrollment_date">Enrollment Date:</label>
            <input type="date" name="enrollment_date" value="<?php echo $student['enrollment_date']; ?>" required>

            <label for="class_assigned">Class Assigned:</label>
            <input type="text" name="class_assigned" value="<?php echo $student['class_assigned']; ?>" required>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" name="profile_picture">

            <button type="submit">Update Student</button>
        </form>
    </div>
    <?php include 'footer.php'; // Include your footer file ?>
</body>
</html>
