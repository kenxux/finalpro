<!-- File: admin_dashboard.php -->
<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}
// Include the database connection
include 'db_connect.php'; // Going one directory up from admin to access db_connect.php
include 'header.php'; // Include header from one directory up

// Fetch the user's profile picture securely using prepared statements
$username = $_SESSION['username'];
$query = "SELECT profile_picture FROM users WHERE username=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$profile_picture = $user['profile_picture'] ? 'assets/images/profiles/' . htmlspecialchars($user['profile_picture']) : 'assets/images/profiles/default_profile_picture.jpg'; // Fallback profile picture
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - School Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->        
</head>
<body>
    <div class="dashboard-container">
        <nav class="sidebar" id="sidebar">
            <div class="profile-info">
                <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture">
                <h2>
                    <span class="active-dot"></span> <!-- Green dot indicating the user is active -->
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                </h2>
            </div>
            
            <!-- Flex container for toggle button and title -->
            <div class="sidebar-header">
                <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            </div>
            

 <div class="nav-tabs" data-content="users">
    <i class="fas fa-chalkboard-teacher" aria-hidden="true"></i><span> Teachers</span>
</div>
<div class="nav-tabs" data-content="students">
    <i class="fas fa-user-graduate" aria-hidden="true"></i><span> Students</span>
</div>
<div class="nav-tabs" data-content="s_staffs">
    <i class="fas fa-user-friends" aria-hidden="true"></i><span> S. Staff</span>
</div>
<div class="nav-tabs" data-content="parents">
    <i class="fas fa-user-tie" aria-hidden="true"></i><span> Parents</span>
</div>
            <a href="logout.php" class="logout-button">Logout</a> <!-- Link to log out -->        
        </nav>        

        <div class="main-content">
            <h1>Welcome mr/mis, <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>, this is an admin's page!</h1>
            
            <!-- Content sections -->
            
            <!-- Dashboard Section -->
            <div id="content-dashboard" class="content-section">
            <h3>Users Dashboard</h3>
                <ul class="dashboard-menu">
    <li><a href="manage_teachers.php" data-title="Teachers"><i class="fas fa-chalkboard-teacher"></i></a></li>
    <li><a href="manage_Students.php" data-title="Students"><i class="fas fa-user-graduate"></i></a></li>
    <li><a href="manage_parents.php" data-title="Parents"><i class="fas fa-user-friends"></i></a></li>
    <li><a href="manage_nonstaffs.php" data-title="Non-T.Staffs"><i class="fas fa-user-tie"></i></a></li>

                </ul>
            </div>
            <!-- Users Section -->
            <div id="content-users" class="content-section">
                <h3>action on teachers</h3>
                <ul class="dashboard-menu">
    <a href="add_teacher.php" class="btn" data-title="Add a Teacher"><i class="fas fa-plus" ></i></a>
    <a href="view_teachers.php" class="btn" data-title="Edit a Teacher"><i class="fas fa-edit" ></i></a>
    <a href="delete_teacher.php" class="btn" data-title="Delete a Teacher"><i class="fas fa-trash"></i></a>
    <a href="view_teachers.php" class="btn" data-title="View Teachers"><i class="fas fa-eye"></i></a>

                </ul>
            </div>
            <div id="content-students" class="content-section">
                <h3>action on Students</h3>
                <ul class="dashboard-menu">
                <a href="add_student.php" class="btn" data-title="Add a Student"><i class="fas fa-plus"></i></a>
                <a href="view_students.php" class="btn" data-title="Edit a Student"><i class="fas fa-edit"></i></a>
                <a href="view_students.php" class="btn" data-title="Delete a Student"><i class="fas fa-trash"></i></a>
                <a href="view_students.php" class="btn" data-title="View Students"><i class="fas fa-eye"></i></a>

                </ul>
            </div>
            <div id="content-parents" class="content-section">
                <h3>action on Parents</h3>
                <ul class="dashboard-menu">
                <a href="add_parent.php" class="btn" data-title="Add a Parent"><i class="fas fa-plus"></i></a>
                <a href="edit_parent.php" class="btn" data-title="Edit a Parent"><i class="fas fa-edit"></i></a>
                <a href="delete_parent.php" class="btn" data-title="Delete a Parent"><i class="fas fa-trash"></i></a>
                <a href="view_parent.php" class="btn" data-title="View Parents"><i class="fas fa-eye"></i></a>

                </ul>
            </div>
            <div id="content-s_staffs" class="content-section">
                <h3>action on support staff</h3>
                <ul class="dashboard-menu">
                <a href="add_nonstaff.php" class="btn" data-title="Add a Non-Teaching Staff"><i class="fas fa-plus"></i></a>
                <a href="edit_nonstaff.php" class="btn" data-title="Edit a Non-Teaching Staff"><i class="fas fa-edit" ></i></a>
                <a href="delete_nonstaff.php" class="btn" data-title="Delete a Non-Teaching Staff"><i class="fas fa-trash"></i></a>
                <a href="view_nonstaff.php" class="btn" data-title="View Non-Teaching Staff"><i class="fas fa-eye" ></i></a>

                </ul>
            </div>

        </div>
    </div>

    <script>
        // JavaScript to handle tab functionality
        const tabs = document.querySelectorAll('.nav-tabs');
        const contentSections = document.querySelectorAll('.content-section');

        // Hide all content sections initially
        contentSections.forEach(section => section.style.display = 'none');

        // Show default content (attendance)
        document.getElementById('content-dashboard').style.display = 'block';

        // Add click event to each tab
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const targetContent = document.getElementById(`content-${tab.getAttribute('data-content')}`);
                // Hide all content sections
                contentSections.forEach(section => section.style.display = 'none');
                // Show the target content
                targetContent.style.display = 'block';
            });
        });

        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }
    </script>
</body>
<?php include 'footer.php'; ?>
</html>
