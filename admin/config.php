<?php
// ====================================
// ADMIN CREDENTIALS - CHANGE THIS!
// ====================================
define('ADMIN_PASSWORD', 'kpjway');  // ← CHANGE THIS PASSWORD!

// ====================================
// DATABASE CONFIGURATION (MySQL)
// ====================================
define('DB_HOST', 'localhost');
define('DB_NAME', 'company_portal');
define('DB_USER', 'root');           // Your phpMyAdmin username
define('DB_PASS', '');               // Your phpMyAdmin password (usually empty for localhost)

// ====================================
// UPLOAD SETTINGS
// ====================================
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

// ====================================
// DATABASE CONNECTION FUNCTION (MySQL)
// ====================================
function getDB() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $db = new PDO($dsn, DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
    } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
    }
}
?>