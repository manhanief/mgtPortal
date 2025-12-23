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
        $stmt = $db->prepare("SELECT * FROM `systems` WHERE `id` = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $data]);
        break;
        
    case 'create':
        $title = $_POST['title'] ?? '';
        $services = $_POST['services'] ?? '';
        $linkUrl = $_POST['link_url'] ?? '';
        $displayOrder = $_POST['display_order'] ?? 0;
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        $iconPath = '';
        if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
            $upload = uploadImage($_FILES['icon'], UPLOAD_DIR . 'systems/', 'icon');
            if ($upload['success']) {
                $iconPath = str_replace('../', '', $upload['path']);
            }
        }
        
        $stmt = $db->prepare("
            INSERT INTO `systems` (`title`, `services`, `link_url`, `icon_path`, `display_order`, `is_active`) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        if ($stmt->execute([$title, $services, $linkUrl, $iconPath, $displayOrder, $isActive])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to create system']);
        }
        break;
        
    case 'update':
        $id = $_POST['id'] ?? 0;
        $title = $_POST['title'] ?? '';
        $services = $_POST['services'] ?? '';
        $linkUrl = $_POST['link_url'] ?? '';
        $displayOrder = $_POST['display_order'] ?? 0;
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        $stmt = $db->prepare("SELECT `icon_path` FROM `systems` WHERE `id` = ?");
        $stmt->execute([$id]);
        $current = $stmt->fetch(PDO::FETCH_ASSOC);
        $iconPath = $current['icon_path'] ?? '';
        
        if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
            if ($iconPath) deleteImage('../' . $iconPath);
            $upload = uploadImage($_FILES['icon'], UPLOAD_DIR . 'systems/', 'icon');
            if ($upload['success']) {
                $iconPath = str_replace('../', '', $upload['path']);
            }
        }
        
        $stmt = $db->prepare("
            UPDATE `systems` 
            SET `title` = ?, `services` = ?, `link_url` = ?, `icon_path` = ?, `display_order` = ?, `is_active` = ? 
            WHERE `id` = ?
        ");
        
        if ($stmt->execute([$title, $services, $linkUrl, $iconPath, $displayOrder, $isActive, $id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update system']);
        }
        break;
        
    case 'delete':
        $id = $_POST['id'] ?? 0;
        
        $stmt = $db->prepare("SELECT `icon_path` FROM `systems` WHERE `id` = ?");
        $stmt->execute([$id]);
        $system = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($system && $system['icon_path']) {
            deleteImage('../' . $system['icon_path']);
        }
        
        $stmt = $db->prepare("DELETE FROM `systems` WHERE `id` = ?");
        if ($stmt->execute([$id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete system']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
}
?>