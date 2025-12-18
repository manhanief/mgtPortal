<?php
require_once 'config.php';
require_once 'auth.php';

if (!isAuthenticated()) {
    header('Location: index.php');
    exit;
}

$type = $_GET['type'] ?? 'news';
$id = (int)($_GET['id'] ?? 1);

// Validate parameters
if (!in_array($type, ['news', 'packages']) || $id < 1 || $id > 4) {
    die('Invalid parameters');
}

$db = getDB();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $details = $_POST['details'] ?? '';
    $imagePath = $_POST['current_image'] ?? '';
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['image'];
        
        // Validate file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (in_array($mimeType, ALLOWED_TYPES) && $file['size'] <= MAX_FILE_SIZE) {
            // Delete old image if exists
            if ($imagePath && file_exists('../' . $imagePath)) {
                unlink('../' . $imagePath);
            }
            
            // Create upload directory if not exists
            $uploadTypeDir = UPLOAD_DIR . $type . '/';
            if (!is_dir($uploadTypeDir)) {
                mkdir($uploadTypeDir, 0755, true);
            }
            
            // Generate new filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newFileName = $type . '_' . $id . '_' . time() . '.' . $extension;
            $uploadPath = $uploadTypeDir . $newFileName;
            
            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $imagePath = 'uploads/' . $type . '/' . $newFileName;
            } else {
                $uploadError = 'Failed to upload image';
            }
        } else {
            $uploadError = 'Invalid file type or size';
        }
    }
    
    // Update database
    if (!isset($uploadError)) {
       // NEW (MySQL syntax)
        $stmt = $db->prepare("
            UPDATE `{$type}` 
            SET `title` = ?, `details` = ?, `image_path` = ?, `update_date` = CURRENT_TIMESTAMP 
            WHERE `id` = ?
        ");
        $stmt->execute([$title, $details, $imagePath, $id]);
        $success = true;
    }
}

// Get current item data

$stmt = $db->prepare("SELECT * FROM `{$type}` WHERE `id` = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    die('Item not found');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?= ucfirst($type) ?> #<?= $id ?></title>
    <link rel="stylesheet" href="assets/admin-style.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>✏️ Edit <?= ucfirst($type) ?> #<?= $id ?></h1>
            <a href="index.php" class="btn-back">← Back to Dashboard</a>
        </header>

        <?php if (isset($success)): ?>
            <div class="alert-success">✅ Updated successfully!</div>
        <?php endif; ?>

        <?php if (isset($uploadError)): ?>
            <div class="alert-error">❌ <?= htmlspecialchars($uploadError) ?></div>
        <?php endif; ?>

        <div class="edit-form">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="current_image" value="<?= htmlspecialchars($item['image_path'] ?? '') ?>">
                
                <!-- Current Image -->
                <div class="form-group">
                    <label>Current Image:</label>
                    <?php if ($item['image_path']): ?>
                        <img src="../<?= htmlspecialchars($item['image_path']) ?>" class="current-image" alt="Current">
                    <?php else: ?>
                        <p class="no-image-text">No image uploaded</p>
                    <?php endif; ?>
                </div>

                <!-- Upload New Image -->
                <div class="form-group">
                    <label for="image">Upload New Image <?= $item['image_path'] ? '(replaces current)' : '' ?>:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <small>Max 5MB. Allowed: JPG, PNG, GIF, WebP</small>
                </div>

                <!-- Title -->
                <div class="form-group">
                    <label for="title">Title: *</label>
                    <input type="text" id="title" name="title" 
                           value="<?= htmlspecialchars($item['title']) ?>" 
                           required maxlength="200">
                </div>

                <!-- Details -->
                <div class="form-group">
                    <label for="details">Details: *</label>
                    <textarea id="details" name="details" rows="8" required><?= htmlspecialchars($item['details']) ?></textarea>
                </div>

                <!-- Update Date Info -->
                <div class="form-group">
                    <label>Last Updated:</label>
                    <p class="info-text"><?= date('F d, Y g:i A', strtotime($item['update_date'])) ?></p>
                    <small>(Will automatically update when you save)</small>
                </div>

                <button type="submit" class="btn-save">💾 Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>