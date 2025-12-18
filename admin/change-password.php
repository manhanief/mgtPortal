<?php
require_once 'config.php';
require_once 'auth.php';

header('Content-Type: application/json');

if (!isAuthenticated()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

// Validate inputs
if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    echo json_encode(['error' => 'All fields are required']);
    exit;
}

// Check current password
if ($currentPassword !== ADMIN_PASSWORD) {
    echo json_encode(['error' => 'Current password is incorrect']);
    exit;
}

// Check if new passwords match
if ($newPassword !== $confirmPassword) {
    echo json_encode(['error' => 'New passwords do not match']);
    exit;
}

// Validate password strength
if (strlen($newPassword) < 6) {
    echo json_encode(['error' => 'Password must be at least 6 characters long']);
    exit;
}

// Update config.php file
$configFile = __DIR__ . '/config.php';
$configContent = file_get_contents($configFile);

// Replace the password line
$pattern = "/define\('ADMIN_PASSWORD',\s*'[^']*'\);/";
$replacement = "define('ADMIN_PASSWORD', '" . addslashes($newPassword) . "');";
$newConfigContent = preg_replace($pattern, $replacement, $configContent);

if ($newConfigContent === null || $newConfigContent === $configContent) {
    echo json_encode(['error' => 'Failed to update password']);
    exit;
}

// Write to file
if (file_put_contents($configFile, $newConfigContent)) {
    // Log out user to force re-login with new password
    logout();
    echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
} else {
    echo json_encode(['error' => 'Failed to save new password']);
}
?>