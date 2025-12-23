<?php
require_once '../config.php';
require_once '../auth.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

if (!isAuthenticated()) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$db = getDB();
$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'get':
        $id = $_GET['id'] ?? 0;
        $stmt = $db->prepare("SELECT * FROM `slideshow` WHERE `id` = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $data]);
        break;
        
    case 'create':
        $title = $_POST['title'] ?? '';
        $details = $_POST['details'] ?? '';
        $linkUrl = $_POST['link_url'] ?? '';
        $displayOrder = $_POST['display_order'] ?? 0;
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'slideshow/', 'slide');
            if ($upload['success']) {
                $imagePath = str_replace('../', '', $upload['path']);
            }
        }
        
        $stmt = $db->prepare("
            INSERT INTO `slideshow` (`title`, `details`, `link_url`, `image_path`, `display_order`, `is_active`) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        if ($stmt->execute([$title, $details, $linkUrl, $imagePath, $displayOrder, $isActive])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to create slide']);
        }
        break;
        
    case 'update':
        $id = $_POST['id'] ?? 0;
        $title = $_POST['title'] ?? '';
        $details = $_POST['details'] ?? '';
        $linkUrl = $_POST['link_url'] ?? '';
        $displayOrder = $_POST['display_order'] ?? 0;
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        // Get current image
        $stmt = $db->prepare("SELECT `image_path` FROM `slideshow` WHERE `id` = ?");
        $stmt->execute([$id]);
        $current = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagePath = $current['image_path'] ?? '';
        
        // Handle new image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Delete old image
            if ($imagePath) {
                deleteImage('../' . $imagePath);
            }
            
        $rootPath = realpath(__DIR__ . '/../../');   // MPortal root
        $publicDir = 'uploads/news/';               // what you WANT
        $uploadDir = $rootPath . '/' . $publicDir;  // filesystem

        $upload = uploadImage($_FILES['image'], $uploadDir, 'news_1');

        if ($upload['success']) {
            // 🔥 EXACT output you want
            $imagePath = $publicDir . $upload['filename'];
        }

        }
        
        $stmt = $db->prepare("
            UPDATE `slideshow` 
            SET `title` = ?, `details` = ?, `link_url` = ?, `image_path` = ?, `display_order` = ?, `is_active` = ? 
            WHERE `id` = ?
        ");
        
        if ($stmt->execute([$title, $details, $linkUrl, $imagePath, $displayOrder, $isActive, $id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update slide']);
        }
        break;
        
    case 'delete':
        $id = $_POST['id'] ?? 0;
        
        // Get image path
        $stmt = $db->prepare("SELECT `image_path` FROM `slideshow` WHERE `id` = ?");
        $stmt->execute([$id]);
        $slide = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Delete image
        if ($slide && $slide['image_path']) {
            deleteImage('../' . $slide['image_path']);
        }
        
        // Delete record
        $stmt = $db->prepare("DELETE FROM `slideshow` WHERE `id` = ?");
        if ($stmt->execute([$id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete slide']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
}
?>