



<?php
// Start the session
session_start();

// Include header
include 'admin/include/header.php';

// Include sidebar
include 'admin/include/sidebar.php';
?>

<!-- Main content starts -->
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <?php
    // Include navbar
    include 'admin/include/navbar.php';
    ?>
    
    <!-- Main Dashboard Content -->
    <div class="container-fluid py-4">
        <h1>Welcome to the Admin Dashboard</h1>
        <!-- Additional content can go here -->
    </div>
</main>

<?php
// Include footer
include 'admin/include/footer.php';
?>
