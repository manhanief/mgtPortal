<?php
// Upload image function
function uploadImage($file, $targetDir, $prefix = 'img') {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Upload failed'];
    }
    
    // Validate file size
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'error' => 'File too large (max 5MB)'];
    }
    
    // Validate file type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);

    finfo_close($finfo);
    if (!in_array($mimeType, ALLOWED_TYPES)) {
        return ['success' => false, 'error' => 'Invalid file type'];
    }
    
    // Create directory if not exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    
    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = $prefix . '_' . time() . '_' . rand(1000, 9999) . '.' . $extension;
    $targetPath = $targetDir . $filename;
    
    // Move file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => true, 'path' => $targetPath, 'filename' => $filename];
    }
    
    return ['success' => false, 'error' => 'Failed to save file'];
}

//get it team list
function getITTeamList($db) {
    $stmt = $db->prepare("SELECT * FROM `it_team` ORDER BY `name` ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Delete image function
function deleteImage($path) {
    if ($path && file_exists($path)) {
        return unlink($path);
    }
    return true;
}

// Get table data
function getTableData($db, $table, $orderBy = 'id', $orderDir = 'ASC') {
    $stmt = $db->prepare("SELECT * FROM `{$table}` ORDER BY `{$orderBy}` {$orderDir}");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Update record
function updateRecord($db, $table, $id, $data) {
    $fields = [];
    $values = [];
    
    foreach ($data as $key => $value) {
        $fields[] = "`{$key}` = ?";
        $values[] = $value;
    }
    
    $values[] = $id;
    $sql = "UPDATE `{$table}` SET " . implode(', ', $fields) . " WHERE `id` = ?";
    
    $stmt = $db->prepare($sql);
    return $stmt->execute($values);
}

// Insert record
function insertRecord($db, $table, $data) {
    $fields = array_keys($data);
    $placeholders = array_fill(0, count($fields), '?');
    
    $sql = "INSERT INTO `{$table}` (`" . implode('`, `', $fields) . "`) VALUES (" . implode(', ', $placeholders) . ")";
    
    $stmt = $db->prepare($sql);
    return $stmt->execute(array_values($data));
}

// Delete record
function deleteRecord($db, $table, $id) {
    $stmt = $db->prepare("DELETE FROM `{$table}` WHERE `id` = ?");
    return $stmt->execute([$id]);
}

// Format date
function formatDate($date) {
    return date('M d, Y', strtotime($date));
}

// Truncate text
function truncateText($text, $length = 100) {
    if (strlen($text) > $length) {
        return substr($text, 0, $length) . '...';
    }
    return $text;
}
?>