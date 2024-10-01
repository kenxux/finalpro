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
            
            <div class="nav-tabs" data-content="dashboard">
                <i class="fas fa-tachometer-alt" aria-hidden="true"></i><span> Dashboard</span>
            </div>
            <div class="nav-tabs" data-content="users">
                <i class="fas fa-users" aria-hidden="true"></i><span> Users</span>
            </div>
            <div class="nav-tabs" data-content="academic">
                <i class="fas fa-graduation-cap" aria-hidden="true"></i><span> Academic </span>
            </div>
            <div class="nav-tabs active-tab" data-content="attendance">
                <i class="fas fa-check-circle" aria-hidden="true"></i><span> Attendance </span>
            </div>
            <div class="nav-tabs" data-content="finance">
                <i class="fas fa-money-bill-wave" aria-hidden="true"></i><span> Finance </span>
            </div>
            <div class="nav-tabs" data-content="events">
                <i class="fas fa-calendar-alt" aria-hidden="true"></i><span> Events & Tasks</span>
            </div>
            <div class="nav-tabs" data-content="behavior">
                <i class="fas fa-smile" aria-hidden="true"></i><span> Behavior</span>
            </div>
            <div class="nav-tabs" data-content="communication">
                <i class="fas fa-comments" aria-hidden="true"></i><span> Communication</span>
            </div>
            <div class="nav-tabs" data-content="transport">
                <i class="fas fa-bus" aria-hidden="true"></i><span> Transport </span>
            </div>
            <div class="nav-tabs" data-content="library">
                <i class="fas fa-book" aria-hidden="true"></i><span> Library </span>
            </div>
            <div class="nav-tabs" data-content="help">
                <i class="fas fa-life-ring" aria-hidden="true"></i><span> Help & Support</span>
            </div>
            <div class="nav-tabs" data-content="system">
                <i class="fas fa-cogs" aria-hidden="true"></i><span> System Settings</span>
            </div>

            <a href="logout.php" class="logout-button">Logout</a> <!-- Link to log out -->        
        </nav>        

        <div class="main-content">
            <h1>Welcome mr/mis, <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>, this is an admin's page!</h1>
            
            <!-- Content sections -->
            
            <!-- Dashboard Section -->
            <div id="content-dashboard" class="content-section">
                <h3>Admin's Dashboard </h3>
                <ul class="dashboard-menu">
    <li><a href="pages/manage_dashboard.php" data-title="Dashboard"><i class="fas fa-tachometer-alt"></i></a></li>
    <li><a href="pages/manage_users.php" data-title="Users"><i class="fas fa-users"></i></a></li>
    <li><a href="pages/manage_academic.php" data-title="Academics"><i class="fas fa-graduation-cap"></i></a></li>
    <li><a href="pages/manage_attendance.php" data-title="Attendance"><i class="fas fa-check-circle"></i></a></li>
    <li><a href="pages/manage_finance.php" data-title="Finance"><i class="fas fa-money-bill-wave"></i></a></li>
    <li><a href="pages/manage_events.php" data-title="Events & Tasks"><i class="fas fa-calendar-alt"></i></a></li>
    <li><a href="pages/manage_behavior.php" data-title="Behavior"><i class="fas fa-smile"></i></a></li>
    <li><a href="pages/manage_communication.php" data-title="Communication"><i class="fas fa-comments"></i></a></li>
    <li><a href="pages/manage_transport.php" data-title="Transport"><i class="fas fa-bus"></i></a></li>
    <li><a href="pages/manage_library.php" data-title="Library"><i class="fas fa-book"></i></a></li>
    <li><a href="pages/manage_help.php" data-title="Help & Support"><i class="fas fa-life-ring"></i></a></li>
    <li><a href="pages/manage_system.php" data-title="System Settings"><i class="fas fa-cogs"></i></a></li>
                </ul>
            </div>
            <!-- Users Section -->
            <div id="content-users" class="content-section">
                <h3>Users Dashboard</h3>
                <ul class="dashboard-menu">
    <li><a href="pages/manage_teachers.php" data-title="Teachers"><i class="fas fa-chalkboard-teacher"></i></a></li>
    <li><a href="pages/manage_students.php" data-title="Students"><i class="fas fa-user-graduate"></i></a></li>
    <li><a href="pages/manage_parents.php" data-title="Parents"><i class="fas fa-user-friends"></i></a></li>
    <li><a href="pages/manage_nonstaffs.php" data-title="Non-T.Staffs"><i class="fas fa-user-tie"></i></a></li>

                </ul>
            </div>

            <!-- Academic Section -->
            <div id="content-academic" class="content-section">
                <h3>Academics Dashboard</h3>
                <ul class="dashboard-menu">
    <li><a href="pages/manage_clubs.php" data-title="Clubs & Societies"><i class="fas fa-users"></i></a></li>
    <li><a href="pages/manage_study_resources.php" data-title="Study Resources"><i class="fas fa-book"></i></a></li>
    <li><a href="pages/manage_academic.php" data-title="Academic Info"><i class="fas fa-graduation-cap"></i></a></li>
    <li><a href="pages/manage_attendance.php" data-title="Attendance Records"><i class="fas fa-check-circle"></i></a></li>
    <li><a href="pages/manage_academic_calendar.php" data-title="Academic Calendar"><i class="fas fa-calendar-alt"></i></a></li>
    <li><a href="pages/manage_course_registration.php" data-title="Course Registration"><i class="fas fa-clipboard-list"></i></a></li>
    <li><a href="pages/manage_laboratories.php" data-title="Laboratories"><i class="fas fa-flask"></i></a></li>
    <li><a href="pages/manage_classes.php" data-title="Classes"><i class="fas fa-chalkboard-teacher"></i></a></li>
    <li><a href="pages/manage_examinations.php" data-title="Examinations"><i class="fas fa-pencil-alt"></i></a></li>
                </ul>
            </div>

            <!-- Attendance Section -->
            <div id="content-attendance" class="content-section">
                <h3>Attendance Dashboard</h3>
                <ul class="dashboard-menu">
    <li><a href="pages/manage_attendance_records.php" data-title="Attendance Records"><i class="fas fa-file-alt"></i></a></li>
    <li><a href="pages/mark_attendance.php" data-title="Mark Attendance"><i class="fas fa-check-circle"></i></a></li>
    <li><a href="pages/attendance_reports.php" data-title="Attendance Reports"><i class="fas fa-chart-line"></i></a></li>
    <li><a href="pages/class_attendance.php" data-title="Class Attendance"><i class="fas fa-users"></i></a></li>
    <li><a href="pages/student_attendance.php" data-title="Student Attendance"><i class="fas fa-user-check"></i></a></li>
    <li><a href="pages/attendance_summary.php" data-title="Attendance Summary"><i class="fas fa-table"></i></a></li>
    <li><a href="pages/attendance_policies.php" data-title="Attendance Policies"><i class="fas fa-book-open"></i></a></li>
                       </ul>
            </div>

            <!-- Finance Section -->
            <div id="content-finance" class="content-section">
                <h3>Finance Dashboard</h3>
                <ul class="dashboard-menu">
    <li><a href="pages/fees_structure.php" data-title="Fees Structure"><i class="fas fa-money-bill-wave"></i></a></li>
    <li><a href="pages/payments.php" data-title="Payments"><i class="fas fa-credit-card"></i></a></li>
    <li><a href="pages/financial_reports.php" data-title="Financial Reports"><i class="fas fa-file-invoice-dollar"></i></a></li>
    <li><a href="pages/budgeting.php" data-title="Budgeting"><i class="fas fa-chart-pie"></i></a></li>
    <li><a href="pages/expenditure_tracking.php" data-title="Expenditure Tracking"><i class="fas fa-chart-line"></i></a></li>
    <li><a href="pages/scholarship_management.php" data-title="Scholarship Management"><i class="fas fa-award"></i></a></li>
    <li><a href="pages/finance_dashboard.php" data-title="Finance Dashboard"><i class="fas fa-tachometer-alt"></i></a></li>
    <li><a href="pages/invoices.php" data-title="Invoices"><i class="fas fa-file-invoice"></i></a></li>

             </ul>
            </div>

            <!-- Events & Tasks Section -->
            <div id="content-events" class="content-section">
                <h3>Events & Tasks Dashboard</h3>
                <ul class="dashboard-menu">
    <li><a href="pages/upcoming_events.php" data-title="Upcoming Events"><i class="fas fa-calendar-alt"></i></a></li>
    <li><a href="pages/event_management.php" data-title="Event Management"><i class="fas fa-edit"></i></a></li>
    <li><a href="pages/tasks_overview.php" data-title="Tasks Overview"><i class="fas fa-tasks"></i></a></li>
    <li><a href="pages/create_event.php" data-title="Create New Event"><i class="fas fa-plus-circle"></i></a></li>
    <li><a href="pages/event_reports.php" data-title="Event Reports"><i class="fas fa-file-alt"></i></a></li>
    <li><a href="pages/task_assignments.php" data-title="Task Assignments"><i class="fas fa-user-check"></i></a></li>
    <li><a href="pages/event_calendar.php" data-title="Event Calendar"><i class="fas fa-calendar"></i></a></li>
    <li><a href="pages/notifications.php" data-title="Notifications"><i class="fas fa-bell"></i></a></li>
                </ul>
            </div>

            <!-- Behavior Section -->
            <div id="content-behavior" class="content-section">
                <h3>Behavior Dashboard</h3>
                <ul class="dashboard-menu">
    <li><a href="pages/student_behavior_records.php" data-title="Student Behavior Records"><i class="fas fa-clipboard-list"></i></a></li>
    <li><a href="pages/disciplinary_actions.php" data-title="Disciplinary Actions"><i class="fas fa-gavel"></i></a></li>
    <li><a href="pages/behavior_reports.php" data-title="Behavior Reports"><i class="fas fa-chart-bar"></i></a></li>
    <li><a href="pages/rewards_recognition.php" data-title="Rewards and Recognition"><i class="fas fa-award"></i></a></li>
    <li><a href="pages/parental_notifications.php" data-title="Parental Notifications"><i class="fas fa-bell"></i></a></li>
    <li><a href="pages/behavior_improvement_plans.php" data-title="Behavior Improvement Plans"><i class="fas fa-thumbs-up"></i></a></li>
    <li><a href="pages/counseling_sessions.php" data-title="Counseling Sessions"><i class="fas fa-comments"></i></a></li>
    <li><a href="pages/attendance_behavior_analysis.php" data-title="Attendance Behavior Analysis"><i class="fas fa-chart-line"></i></a></li>
                </ul>
            </div>

            <!-- Communication Section -->
            <div id="content-communication" class="content-section">
                <h3>Communication Dashboard</h3>
                <ul class="dashboard-menu">
    <li><a href="pages/messages.php" data-title="Messages"><i class="fas fa-comments"></i></a></li>
    <li><a href="pages/announcements.php" data-title="Announcements"><i class="fas fa-bullhorn"></i></a></li>
    <li><a href="pages/discussion_forums.php" data-title="Discussion Forums"><i class="fas fa-users"></i></a></li>
    <li><a href="pages/feedback_suggestions.php" data-title="Feedback and Suggestions"><i class="fas fa-comment-dots"></i></a></li>
    <li><a href="pages/email_notifications.php" data-title="Email Notifications"><i class="fas fa-envelope"></i></a></li>
    <li><a href="pages/parent_teacher_communication.php" data-title="Parent-Teacher Communication"><i class="fas fa-user-friends"></i></a></li>
    <li><a href="pages/event_notifications.php" data-title="Event Notifications"><i class="fas fa-calendar-alt"></i></a></li>
    <li><a href="pages/chat_support.php" data-title="Chat Support"><i class="fas fa-headset"></i></a></li>
                </ul>
            </div>

            <!-- Transport Section -->
            <div id="content-transport" class="content-section">
                <h3>Transport Dashboard</h3>
                <ul class="dashboard-menu">
                <li><a href="pages/manage_transport.php" data-title="Transport Management"><i class="fas fa-bus"></i></a></li>
    <li><a href="pages/manage_routes.php" data-title="Route Management"><i class="fas fa-route"></i></a></li>
    <li><a href="pages/manage_maintenance.php" data-title="Vehicle Maintenance"><i class="fas fa-tools"></i></a></li>
    <li><a href="pages/manage_drivers.php" data-title="Driver Management"><i class="fas fa-user-tie"></i></a></li>
    <li><a href="pages/manage_requests.php" data-title="Transport Requests"><i class="fas fa-paper-plane"></i></a></li>
    <li><a href="pages/manage_policies.php" data-title="Transport Policies"><i class="fas fa-file-alt"></i></a></li>
    <li><a href="pages/manage_reports.php" data-title="Reports"><i class="fas fa-chart-line"></i></a></li>
    <li><a href="pages/manage_feedback.php" data-title="Feedback & Complaints"><i class="fas fa-comment-dots"></i></a></li>
                </ul>
            </div>

            <!-- Library Section -->
            <div id="content-library" class="content-section">
                <h3>Library Dashboard</h3>
                <ul class="dashboard-menu">
                <li><a href="pages/manage_library.php" data-title="Library Management"><i class="fas fa-book"></i></a></li>
    <li><a href="pages/manage_catalog.php" data-title="Book Catalog"><i class="fas fa-book-open"></i></a></li>
    <li><a href="pages/manage_borrowing.php" data-title="Borrowing Records"><i class="fas fa-file-alt"></i></a></li>
    <li><a href="pages/manage_members.php" data-title="Membership Management"><i class="fas fa-users"></i></a></li>
    <li><a href="pages/manage_reservations.php" data-title="Reservations"><i class="fas fa-calendar-check"></i></a></li>
    <li><a href="pages/manage_fines.php" data-title="Fines Management"><i class="fas fa-money-bill-wave"></i></a></li>
    <li><a href="pages/manage_policies.php" data-title="Library Policies"><i class="fas fa-file-contract"></i></a></li>
    <li><a href="pages/manage_reports.php" data-title="Reports"><i class="fas fa-chart-line"></i></a></li>
                </ul>
            </div>

            <!-- Help & Support Section -->
            <div id="content-help" class="content-section">
                <h3>Help & Support Dashboard</h3>
                <ul class="dashboard-menu">
                <li><a href="pages/manage_faqs.php" data-title="FAQs"><i class="fas fa-question-circle"></i></a></li>
    <li><a href="pages/manage_contact.php" data-title="Contact Support"><i class="fas fa-envelope"></i></a></li>
    <li><a href="pages/manage_ticket.php" data-title="Submit a Ticket"><i class="fas fa-ticket-alt"></i></a></li>
    <li><a href="pages/manage_guides.php" data-title="User Guides"><i class="fas fa-book"></i></a></li>
    <li><a href="pages/manage_feedback.php" data-title="Feedback"><i class="fas fa-comments"></i></a></li>
    <li><a href="pages/manage_livechat.php" data-title="Live Chat"><i class="fas fa-comments"></i></a></li>
    <li><a href="pages/manage_technical_support.php" data-title="Technical Support"><i class="fas fa-tools"></i></a></li>
    <li><a href="pages/manage_policy.php" data-title="Policy & Terms"><i class="fas fa-file-alt"></i></a></li>
                </ul>
            </div>

            <!-- System Settings Section -->
            <div id="content-system" class="content-section">
                <h3>System Settings Dashboard</h3>
                <ul class="dashboard-menu">
                <li><a href="pages/manage_users.php" data-title="User Management"><i class="fas fa-user-cog"></i></a></li>
    <li><a href="pages/manage_roles.php" data-title="Roles and Permissions"><i class="fas fa-lock"></i></a></li>
    <li><a href="pages/manage_config.php" data-title="System Configuration"><i class="fas fa-cogs"></i></a></li>
    <li><a href="pages/manage_backup.php" data-title="Backup and Restore"><i class="fas fa-database"></i></a></li>
    <li><a href="pages/manage_notifications.php" data-title="Notification Settings"><i class="fas fa-bell"></i></a></li>
    <li><a href="pages/manage_logs.php" data-title="System Logs"><i class="fas fa-file-alt"></i></a></li>
    <li><a href="pages/manage_api.php" data-title="API Settings"><i class="fas fa-code"></i></a></li>
    <li><a href="pages/manage_privacy.php" data-title="Data Privacy"><i class="fas fa-shield-alt"></i></a></li>
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
