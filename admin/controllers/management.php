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

// Validate table name
$allowedTables = ['top_management', 'board_directors', 'senior_management'];
$table = $_REQUEST['table'] ?? '';
if (!in_array($table, $allowedTables)) {
echo json_encode(['success' => false, 'error' => 'Invalid table']);
exit;
}
switch ($action) {
case 'get':
$id = $_GET['id'] ?? 0;
$stmt = $db->prepare("SELECT * FROM {$table} WHERE id = ?");
        stmt−>execute([stmt->execute([
stmt−>execute([id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $data]);
        break;
case 'update':
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $position = $_POST['position'] ?? '';
    $displayOrder = $_POST['display_order'] ?? 0;
    
    $stmt = $db->prepare("SELECT `image_path` FROM `{$table}` WHERE `id` = ?");
    $stmt->execute([$id]);
    $current = $stmt->fetch(PDO::FETCH_ASSOC);
    $imagePath = $current['image_path'] ?? '';
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if ($imagePath) deleteImage('../' . $imagePath);
        $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'management/', 'member');
        if ($upload['success']) {
            $imagePath = str_replace('../', '', $upload['path']);
        }
    }
    
    $stmt = $db->prepare("
        UPDATE `{$table}` 
        SET `name` = ?, `position` = ?, `image_path` = ?, `display_order` = ? 
        WHERE `id` = ?
    ");
    
    if ($stmt->execute([$name, $position, $imagePath, $displayOrder, $id])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update']);
    }
    break;
    
default:
    echo json_encode(['success' => false, 'error' => 'Invalid action']);
}
?>