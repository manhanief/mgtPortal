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

// Get current data
$stmt = $db->prepare("SELECT * FROM `about_us` WHERE `id` = 1");
$stmt->execute();
$current = $stmt->fetch(PDO::FETCH_ASSOC);

$description = $_POST['description'] ?? '';
$bedsCount = $_POST['beds_count'] ?? 0;
$residentCount = $_POST['resident_count'] ?? 0;
$visitingCount = $_POST['visiting_count'] ?? 0;
$sessionalCount = $_POST['sessional_count'] ?? 0;
$moNumber = $_POST['mo_number'] ?? '';
$vision = $_POST['vision'] ?? '';
$mission = $_POST['mission'] ?? '';
$imagePath = $current['image_path'] ?? '';  
$visionMissionImage = $current['vision_mission_image'] ?? '';

// Handle main image upload
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    if ($imagePath) deleteImage('../' . $imagePath);
        $publicDir = 'uploads/about/';               // what you WANT
        $uploadDir = '/' . $publicDir;  // filesystem
    $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'about/', 'about');
    if ($upload['success']) {
        $imagePath = $publicDir . $upload['filename'];
    }
}

// Handle vision/mission image upload
if (isset($_FILES['vision_mission_image']) && $_FILES['vision_mission_image']['error'] === UPLOAD_ERR_OK) {
    if ($visionMissionImage) deleteImage('../' . $visionMissionImage);

            $publicDir = 'uploads/about/';               // what you WANT
        $uploadDir = '/' . $publicDir;  // filesystem
    $upload = uploadImage($_FILES['vision_mission_image'], UPLOAD_DIR . 'about/', 'vision');
    if ($upload['success']) {
        $visionMissionImage = $publicDir . $upload['filename'];
    }
}

$stmt = $db->prepare("
    UPDATE `about_us` 
    SET `image_path` = ?, `description` = ?, `beds_count` = ?, `resident_count` = ?, 
        `visiting_count` = ?, `sessional_count` = ?, `mo_number` = ?, `vision` = ?, 
        `mission` = ?, `vision_mission_image` = ?
    WHERE `id` = 1
");

if ($stmt->execute([
    $imagePath, $description, $bedsCount, $residentCount, 
    $visitingCount, $sessionalCount, $moNumber, $vision, 
    $mission, $visionMissionImage
])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update']);
}
?>