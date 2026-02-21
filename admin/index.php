<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'includes/functions.php';

/* ==========================
   AUTH HANDLING
========================== */

// Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if (authenticate($_POST['password'])) {
        header('Location: index.php');
        exit;
    }
    $loginError = true;
}

// Logout
if (isset($_GET['logout'])) {
    logout();
    header('Location: index.php');
    exit;
}

// Authentication check
if (!isAuthenticated()) {
    include 'pages/login.php';
    exit;
}

/* ==========================
   ROUTING
========================== */

$routes = [
    // Dashboard
    'dashboard'         => 'pages/dashboard.php',

    // Home
    'slideshow'         => 'pages/home/slideshow.php',
    'systems'           => 'pages/home/systems.php',

    // About
    'about'             => 'pages/about/index.php',
    'management'        => 'pages/about/management.php',

    // IT Personnel
    'it_team'              => 'pages/it_personnel/it_team.php',
    'it_roster'            => 'pages/it_personnel/roster.php',
    'it_special_days'      => 'pages/it_personnel/special_days.php',

    // eLearning
    'slides'            => 'pages/home/slideshow.php',
    'tickets'           => 'pages/elearning/tickets.php',

    // Other
    'news'              => 'pages/updates/news.php',
    'packages'          => 'pages/updates/packages.php',
    'settings'          => 'pages/settings.php',
    'sustainability'    => 'pages/sustainability/index.php',
    'extensions'        => 'pages/phone_extension/index.php',
    'staff'             => 'pages/new_staff/index.php',
];

// Current page (safe default)
$currentPage = $_GET['page'] ?? 'dashboard';
$pageFile = $routes[$currentPage] ?? null;

/* ==========================
   DATA LOADING
========================== */

$db = getDB();

if ($currentPage === 'dashboard') {
    $news = $db->query(
        "SELECT * FROM news ORDER BY id DESC LIMIT 4"
    )->fetchAll(PDO::FETCH_ASSOC);

    $packages = $db->query(
        "SELECT * FROM packages ORDER BY id DESC LIMIT 4"
    )->fetchAll(PDO::FETCH_ASSOC);
}

/* ==========================
   PAGE META
========================== */

$pageTitle = ucwords(str_replace('-', ' ', $currentPage));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Admin – <?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="assets/admin-style.css">
</head>
<body>

<div class="admin-container">

    <?php include 'includes/header.php'; ?>
    <?php include 'includes/navigation.php'; ?>

    <main class="dashboard">
        <?php
        if ($pageFile && file_exists($pageFile)) {
            require $pageFile;
        } else {
            require 'pages/404.php';
        }
        ?>
    </main>
</div>

<script src="assets/script.js"></script>
</body>
</html>

