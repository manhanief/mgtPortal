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
        $stmt = $db->prepare("SELECT * FROM `elearning_slides` WHERE `id` = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $data]);
        break;
        
    case 'create':
        $title = $_POST['title'] ?? '';
        $slideNumber = $_POST['slide_number'] ?? null;
        $content = $_POST['content'] ?? '';
        $videoUrl = $_POST['video_url'] ?? '';
        $displayOrder = $_POST['display_order'] ?? 0;
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'elearning/', 'slide');
            if ($upload['success']) {
                $imagePath = str_replace('../', '', $upload['path']);
            }
        }
        
        $stmt = $db->prepare("
            INSERT INTO `elearning_slides` (`title`, `slide_number`, `content`, `video_url`, `image_path`, `display_order`, `is_active`) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        if ($stmt->execute([$title, $slideNumber, $content, $videoUrl, $imagePath, $displayOrder, $isActive])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to create']);
        }
        break;
        
    case 'update':
        $id = $_POST['id'] ?? 0;
        $title = $_POST['title'] ?? '';
        $slideNumber = $_POST['slide_number'] ?? null;
        $content = $_POST['content'] ?? '';
        $videoUrl = $_POST['video_url'] ?? '';
        $displayOrder = $_POST['display_order'] ?? 0;
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        $stmt = $db->prepare("SELECT `image_path` FROM `elearning_slides` WHERE `id` = ?");
        $stmt->execute([$id]);
        $current = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagePath = $current['image_path'] ?? '';
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            if ($imagePath) deleteImage('../' . $imagePath);
            $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'elearning/', 'slide');
            if ($upload['success']) {
                $imagePath = str_replace('../', '', $upload['path']);
            }
        }
        
        $stmt = $db->prepare("
            UPDATE `elearning_slides` 
            SET `title` = ?, `slide_number` = ?, `content` = ?, `video_url` = ?, `image_path` = ?, `display_order` = ?, `is_active` = ? 
            WHERE `id` = ?
        ");
        
        if ($stmt->execute([$title, $slideNumber, $content, $videoUrl, $imagePath, $displayOrder, $isActive, $id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update']);
        }
        break;
        
    case 'delete':
        $id = $_POST['id'] ?? 0;
        
        $stmt = $db->prepare("SELECT `image_path` FROM `elearning_slides` WHERE `id` = ?");
        $stmt->execute([$id]);
        $slide = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($slide && $slide['image_path']) {
            deleteImage('../' . $slide['image_path']);
        }
        
        $stmt = $db->prepare("DELETE FROM `elearning_slides` WHERE `id` = ?");
        if ($stmt->execute([$id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
}
?>