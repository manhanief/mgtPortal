---

### **File: `admin/controllers/special-days.php`**
```php
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
    // Special Day Week Actions
    case 'get_day':
        $id = $_GET['id'] ?? 0;
        $stmt = $db->prepare("SELECT * FROM `special_day_week` WHERE `id` = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $data]);
        break;
        
    case 'create_day':
        $weekNumber = $_POST['week_number'] ?? 0;
        $dayNumber = $_POST['day_number'] ?? 0;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'special-days/', 'day');
            if ($upload['success']) {
                $imagePath = str_replace('../', '', $upload['path']);
            }
        }
        
        $stmt = $db->prepare("
            INSERT INTO `special_day_week` (`week_number`, `day_number`, `title`, `description`, `image_path`) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        if ($stmt->execute([$weekNumber, $dayNumber, $title, $description, $imagePath])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to create']);
        }
        break;
        
    case 'update_day':
        $id = $_POST['id'] ?? 0;
        $weekNumber = $_POST['week_number'] ?? 0;
        $dayNumber = $_POST['day_number'] ?? 0;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        
        $stmt = $db->prepare("SELECT `image_path` FROM `special_day_week` WHERE `id` = ?");
        $stmt->execute([$id]);
        $current = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagePath = $current['image_path'] ?? '';
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            if ($imagePath) deleteImage('../' . $imagePath);
            $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'special-days/', 'day');
            if ($upload['success']) {
                $imagePath = str_replace('../', '', $upload['path']);
            }
        }
        
        $stmt = $db->prepare("
            UPDATE `special_day_week` 
            SET `week_number` = ?, `day_number` = ?, `title` = ?, `description` = ?, `image_path` = ? 
            WHERE `id` = ?
        ");
        
        if ($stmt->execute([$weekNumber, $dayNumber, $title, $description, $imagePath, $id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update']);
        }
        break;
        
    case 'delete_day':
        $id = $_POST['id'] ?? 0;
        
        $stmt = $db->prepare("SELECT `image_path` FROM `special_day_week` WHERE `id` = ?");
        $stmt->execute([$id]);
        $day = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($day && $day['image_path']) {
            deleteImage('../' . $day['image_path']);
        }
        
        $stmt = $db->prepare("DELETE FROM `special_day_week` WHERE `id` = ?");
        if ($stmt->execute([$id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete']);
        }
        break;
        
    // Public Holiday Actions
    case 'get_holiday':
        $id = $_GET['id'] ?? 0;
        $stmt = $db->prepare("SELECT * FROM `public_holidays` WHERE `id` = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $data]);
        break;
        
    case 'create_holiday':
        $date = $_POST['date'] ?? '';
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        $stmt = $db->prepare("
            INSERT INTO `public_holidays` (`date`, `title`, `description`, `is_active`) 
            VALUES (?, ?, ?, ?)
        ");
        
        if ($stmt->execute([$date, $title, $description, $isActive])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to create']);
        }
        break;
        
    case 'update_holiday':
        $id = $_POST['id'] ?? 0;
        $date = $_POST['date'] ?? '';
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        $stmt = $db->prepare("
            UPDATE `public_holidays` 
            SET `date` = ?, `title` = ?, `description` = ?, `is_active` = ? 
            WHERE `id` = ?
        ");
        
        if ($stmt->execute([$date, $title, $description, $isActive, $id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update']);
        }
        break;
        
    case 'delete_holiday':
        $id = $_POST['id'] ?? 0;
        
        $stmt = $db->prepare("DELETE FROM `public_holidays` WHERE `id` = ?");
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
```

---

**Continue with E-Learning, Sustainability, and Extensions?** 🚀