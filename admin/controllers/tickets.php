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
        $stmt = $db->prepare("SELECT * FROM `learning_tickets` WHERE `id` = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $data]);
        break;
        
    case 'create':
        $ticketNo = $_POST['ticket_no'] ?? '';
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $date = $_POST['date'] ?? null;
        $status = $_POST['status'] ?? 'pending';
        
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $publicDir = 'uploads/tickets/';               // what you WANT
                $uploadDir = '/' . $publicDir;  // filesystem
            
            $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'tickets/', 'ticket');
            if ($upload['success']) {
                 $imagePath = $publicDir . $upload['filename'];
            }
        }
        
        $stmt = $db->prepare("
            INSERT INTO `learning_tickets` (`ticket_no`, `title`, `description`, `date`, `status`, `image_path`) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        if ($stmt->execute([$ticketNo, $title, $description, $date, $status, $imagePath])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to create']);
        }
        break;
        
    case 'update':
        $id = $_POST['id'] ?? 0;
        $ticketNo = $_POST['ticket_no'] ?? '';
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $date = $_POST['date'] ?? null;
        $status = $_POST['status'] ?? 'pending';
        
        $stmt = $db->prepare("SELECT `image_path` FROM `learning_tickets` WHERE `id` = ?");
        $stmt->execute([$id]);
        $current = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagePath = $current['image_path'] ?? '';
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            
            if ($imagePath) deleteImage('../' . $imagePath);
            
             $publicDir = 'uploads/tickets/';               // what you WANT
             $uploadDir = '/' . $publicDir;  // filesystem
            $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'tickets/', 'ticket');
            if ($upload['success']) {
                $imagePath = $publicDir . $upload['filename'];
            }
        }
        
        $stmt = $db->prepare("
            UPDATE `learning_tickets` 
            SET `ticket_no` = ?, `title` = ?, `description` = ?, `date` = ?, `status` = ?, `image_path` = ? 
            WHERE `id` = ?
        ");
        
        if ($stmt->execute([$ticketNo, $title, $description, $date, $status, $imagePath, $id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update']);
        }
        break;
        
    case 'delete':
        $id = $_POST['id'] ?? 0;
        
        $stmt = $db->prepare("SELECT `image_path` FROM `learning_tickets` WHERE `id` = ?");
        $stmt->execute([$id]);
        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($ticket && $ticket['image_path']) {
            deleteImage('../' . $ticket['image_path']);
        }
        
        $stmt = $db->prepare("DELETE FROM `learning_tickets` WHERE `id` = ?");
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