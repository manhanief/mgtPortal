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
        $stmt = $db->prepare("SELECT * FROM `it_team` WHERE `id` = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $data]);
        break;
        
    case 'create':
        $name = $_POST['name'] ?? '';
        $position = $_POST['position'] ?? '';
        $email = $_POST['email'] ?? '';
        $extensionNo = $_POST['extension_no'] ?? '';
        $displayOrder = $_POST['display_order'] ?? 0;
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $publicDir = 'uploads/it-team/';               // what you WANT
            $uploadDir = '/' . $publicDir;  // filesystem    
            $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'it-team/', 'it');
            if ($upload['success']) {
                $imagePath = $publicDir . $upload['filename'];
            }
        }
        
        $stmt = $db->prepare("
            INSERT INTO `it_team` (`name`, `position`, `email`, `extension_no`, `image_path`, `display_order`, `is_active`) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        if ($stmt->execute([$name, $position, $email, $extensionNo, $imagePath, $displayOrder, $isActive])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to create member']);
        }
        break;
        
    case 'update':
        $id = $_POST['id'] ?? 0;
        $name = $_POST['name'] ?? '';
        $position = $_POST['position'] ?? '';
        $email = $_POST['email'] ?? '';
        $extensionNo = $_POST['extension_no'] ?? '';
        $displayOrder = $_POST['display_order'] ?? 0;
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        $stmt = $db->prepare("SELECT `image_path` FROM `it_team` WHERE `id` = ?");
        $stmt->execute([$id]);
        $current = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagePath = $current['image_path'] ?? '';
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $publicDir = 'uploads/it-team/';               // what you WANT
            $uploadDir = '/' . $publicDir;  // filesystem
            if ($imagePath) deleteImage('../' . $imagePath);
            $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'it-team/', 'it');
            if ($upload['success']) {
                $imagePath = $publicDir . $upload['filename'];
            }
        }
        
        $stmt = $db->prepare("
            UPDATE `it_team` 
            SET `name` = ?, `position` = ?, `email` = ?, `extension_no` = ?, `image_path` = ?, `display_order` = ?, `is_active` = ? 
            WHERE `id` = ?
        ");
        
        if ($stmt->execute([$name, $position, $email, $extensionNo, $imagePath, $displayOrder, $isActive, $id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update']);
        }
        break;
        
    case 'delete':
        $id = $_POST['id'] ?? 0;
        
        $stmt = $db->prepare("SELECT `image_path` FROM `it_team` WHERE `id` = ?");
        $stmt->execute([$id]);
        $member = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($member && $member['image_path']) {
            deleteImage('../' . $member['image_path']);
        }
        
        $stmt = $db->prepare("DELETE FROM `it_team` WHERE `id` = ?");
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