<?php
header('Content-Type: application/json; charset=utf-8');

require_once '../config.php';
require_once '../auth.php';
require_once '../includes/functions.php';

/* ---------------- ERROR PROTECTION ---------------- */

// Do NOT print PHP errors into response
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Convert PHP warnings/notices into exceptions
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

/* ---------------- JSON RESPONSE HELPER ---------------- */

function jsonResponse($success, $data = null, $error = null, $code = 200) {
    http_response_code($code);
    echo json_encode([
        'success' => $success,
        'data'    => $data,
        'error'   => $error
    ]);
    exit;
}

/* ---------------- MAIN LOGIC ---------------- */

try {

    if (!isAuthenticated()) {
        jsonResponse(false, null, 'Unauthorized', 401);
    }

    $db = getDB();
    $action = $_REQUEST['action'] ?? '';

    switch ($action) {

        /* ---------- GET ONE ---------- */
        case 'get':
            $id = $_GET['id'] ?? 0;

            $stmt = $db->prepare("SELECT * FROM onboarding WHERE id = ?");
            $stmt->execute([$id]);

            jsonResponse(true, $stmt->fetch(PDO::FETCH_ASSOC));
            break;


        /* ---------- CREATE ---------- */
        case 'create':
            $name     = $_POST['name'] ?? '';
            $isActive = isset($_POST['is_active']) ? 1 : 0;
            $imagePath = '';

            if (!empty($_FILES['image']['name'])) {
                $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'onboarding/', 'slide');

                if (!$upload['success']) {
                    jsonResponse(false, null, $upload['error']);
                }

                $imagePath = 'uploads/onboarding/' . $upload['filename'];
            }

            $stmt = $db->prepare("
                INSERT INTO onboarding (name, image_path, is_active)
                VALUES (?, ?, ?)
            ");

            if ($stmt->execute([$name, $imagePath, $isActive])) {
                echo json_encode(['success' => true]);
            }else{
                echo json_encode(['success' => false, 'error' => 'Failed to create staff member']);
            }

            break;


        /* ---------- UPDATE ---------- */
        case 'update':
            $id       = $_POST['id'] ?? 0;
            $name     = $_POST['name'] ?? '';
            $isActive = isset($_POST['is_active']) ? 1 : 0;
            $imagePath = '';

            // Get current image
            $stmt = $db->prepare("SELECT image_path FROM onboarding WHERE id = ?");
            $stmt->execute([$id]);
            $current = $stmt->fetch(PDO::FETCH_ASSOC);
            $imagePath = $current['image_path'] ?? '';

            // New image upload
            if (!empty($_FILES['image']['name'])) {

                if ($imagePath) {
                    deleteImage('../' . $imagePath);
                }

                $upload = uploadImage($_FILES['image'], UPLOAD_DIR . 'onboarding/', 'slide');

                if (!$upload['success']) {
                    jsonResponse(false, null, $upload['error']);
                }

                $imagePath = 'uploads/onboarding/' . $upload['filename'];
            }

            $stmt = $db->prepare("
                UPDATE onboarding
                SET name = ?, image_path = ?, is_active = ?
                WHERE id = ?
            ");


            if ($stmt->execute([$name, $imagePath, $isActive, $id])) {
                echo json_encode(['success' => true]);
            }else{
                echo json_encode(['success' => false, 'error' => 'Failed to update staff member']);
            }

            break;


        /* ---------- DELETE ---------- */
        case 'delete':
            $id = $_POST['id'] ?? 0;

            $stmt = $db->prepare("SELECT image_path FROM onboarding WHERE id = ?");
            $stmt->execute([$id]);
            $slide = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($slide && $slide['image_path']) {
                deleteImage('../' . $slide['image_path']);
            }

            $stmt = $db->prepare("DELETE FROM onboarding WHERE id = ?");
            

            if ($stmt->execute([$id])) {
                echo json_encode(['success' => true]);
            }else{
                echo json_encode(['success' => false, 'error' => 'Failed to delete staff member']);
            }

            break;


        /* ---------- INVALID ---------- */
        default:
            jsonResponse(false, null, 'Invalid action', 400);
    }

} catch (Throwable $e) {

    // Log real error for developer
    error_log($e->getMessage());

    // Send safe JSON to frontend
    jsonResponse(false, null, 'Server error', 500);
}
