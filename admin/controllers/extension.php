

### **File: `admin/handlers/extensions-handler.php`**
```php
<?php
require_once '../config.php';
require_once '../auth.php';

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
        $stmt = $db->prepare("SELECT * FROM `extensions` WHERE `id` = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $data]);
        break;
        
    case 'create':
        $title = $_POST['title'] ?? '';
        $service = $_POST['service'] ?? '';
        $roomNo = $_POST['room_no'] ?? '';
        $clinicNo = $_POST['clinic_no'] ?? '';
        $extensionNo = $_POST['extension_no'] ?? '';
        $department = $_POST['department'] ?? '';
        $displayOrder = $_POST['display_order'] ?? 0;
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        $stmt = $db->prepare("
            INSERT INTO `extensions` (`title`, `service`, `room_no`, `clinic_no`, `extension_no`, `department`, `display_order`, `is_active`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        if ($stmt->execute([$title, $service, $roomNo, $clinicNo, $extensionNo, $department, $displayOrder, $isActive])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to create']);
        }
        break;
        
    case 'update':
        $id = $_POST['id'] ?? 0;
        $title = $_POST['title'] ?? '';
        $service = $_POST['service'] ?? '';
        $roomNo = $_POST['room_no'] ?? '';
        $clinicNo = $_POST['clinic_no'] ?? '';
        $extensionNo = $_POST['extension_no'] ?? '';
        $department = $_POST['department'] ?? '';
        $displayOrder = $_POST['display_order'] ?? 0;
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        $stmt = $db->prepare("
            UPDATE `extensions` 
            SET `title` = ?, `service` = ?, `room_no` = ?, `clinic_no` = ?, `extension_no` = ?, `department` = ?, `display_order` = ?, `is_active` = ? 
            WHERE `id` = ?
        ");
        
        if ($stmt->execute([$title, $service, $roomNo, $clinicNo, $extensionNo, $department, $displayOrder, $isActive, $id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update']);
        }
        break;
        
    case 'delete':
        $id = $_POST['id'] ?? 0;
        
        $stmt = $db->prepare("DELETE FROM `extensions` WHERE `id` = ?");
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