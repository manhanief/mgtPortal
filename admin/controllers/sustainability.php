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
$stmt = $db->prepare("SELECT * FROM sustainability WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $data]);
        break;
        
case 'create':
    $title = $_POST['title'] ?? '';
    $numberValue = $_POST['number_value'] ?? null;
    $description = $_POST['description'] ?? '';
    $displayOrder = $_POST['display_order'] ?? 0;
    
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'sustainability/', 'sustain');
        if ($upload['success']) {
            $imagePath = str_replace('../', '', $upload['path']);
        }
    }
    
    $stmt = $db->prepare("
        INSERT INTO `sustainability` (`title`, `number_value`, `description`, `image_path`, `display_order`) 
        VALUES (?, ?, ?, ?, ?)
    ");
    
    if ($stmt->execute([$title, $numberValue, $description, $imagePath, $displayOrder])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to create']);
    }
    break;
    
case 'update':
    $id = $_POST['id'] ?? 0;
    $title = $_POST['title'] ?? '';
    $numberValue = $_POST['number_value'] ?? null;
    $description = $_POST['description'] ?? '';
    $displayOrder = $_POST['display_order'] ?? 0;
    
    $stmt = $db->prepare("SELECT `image_path` FROM `sustainability` WHERE `id` = ?");
    $stmt->execute([$id]);
    $current = $stmt->fetch(PDO::FETCH_ASSOC);
    $imagePath = $current['image_path'] ?? '';
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if ($imagePath) deleteImage('../' . $imagePath);
        $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'sustainability/', 'sustain');
        if ($upload['success']) {
            $imagePath = str_replace('../', '', $upload['path']);
        }
    }
    
    $stmt = $db->prepare("
        UPDATE `sustainability` 
        SET `title` = ?, `number_value` = ?, `description` = ?, `image_path` = ?, `display_order` = ? 
        WHERE `id` = ?
    ");
    
    if ($stmt->execute([$title, $numberValue, $description, $imagePath, $displayOrder, $id])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update']);
    }
    break;
    
case 'delete':
    $id = $_POST['id'] ?? 0;
    
    $stmt = $db->prepare("SELECT `image_path` FROM `sustainability` WHERE `id` = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($item && $item['image_path']) {
        deleteImage('../' . $item['image_path']);
    }
    
    $stmt = $db->prepare("DELETE FROM `sustainability` WHERE `id` = ?");
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
