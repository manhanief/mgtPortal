<?php
require_once 'config.php';
require_once 'auth.php';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if (authenticate($_POST['password'])) {
        header('Location: index.php');
        exit;
    }
    $loginError = true;
}

// Handle logout
if (isset($_GET['logout'])) {
    logout();
    header('Location: index.php');
    exit;
}

// Check authentication
if (!isAuthenticated()) {
    include 'login.php';
    exit;
}

// Get current page from URL (default: dashboard)
$currentPage = $_GET['page'] ?? 'dashboard';

// Validate page (security)
$allowedPages = ['dashboard', 'news', 'packages', 'settings'];
if (!in_array($currentPage, $allowedPages)) {
    $currentPage = 'dashboard';
}

// Get data from database
$db = getDB();
$news = $db->query("SELECT * FROM `news` ORDER BY `id`")->fetchAll(PDO::FETCH_ASSOC);
$packages = $db->query("SELECT * FROM `packages` ORDER BY `id`")->fetchAll(PDO::FETCH_ASSOC);

// Page title
$pageTitle = ucfirst($currentPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Admin - <?= $pageTitle ?></title>
    <link rel="stylesheet" href="assets/admin-style.css">
</head>
<body>
    <div class="admin-container">
        <?php 
        // Include header
        include 'includes/header.php'; 
        
        // Include navigation
        include 'includes/navigation.php'; 
        ?>

        <!-- Main Content Area -->
        <div class="dashboard">
            <?php 
            // Load page content dynamically
            $pageFile = "pages/{$currentPage}.php";
            if (file_exists($pageFile)) {
                include $pageFile;
            } else {
                echo '<p>Page not found.</p>';
            }
            ?>
        </div>

        <?php 
        // Include footer (optional)
        // include 'includes/footer.php'; 
        ?>
    </div>

    <script src="assets/admin-script.js"></script>
</body>
</html>