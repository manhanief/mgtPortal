<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>KRSH IT PORTAL — KPJ Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        :root {
            --accent:   #2563eb;
            --danger:   #dc2626;
            --success:  #16a34a;
            --surface:  #ffffff;
            --bg:       #f8f9fb;
            --border:   #e5e7eb;
            --text:     #111827;
            --muted:    #6b7280;
            --radius:   8px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
        }

        .page-wrap {
            max-width: 1000px;
            margin: 0 auto;
            padding: 36px 24px 80px;
        }

        /* ── Page header ── */
        .page-header {
            margin-bottom: 28px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }
        .page-header h1 {
            font-size: 1.2rem;
            font-weight: 600;
        }
        .page-header p {
            font-size: .81rem;
            color: var(--muted);
            margin-top: 4px;
        }

        /* ── Section card ── */
        .section-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .section-card-head {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            background: #fafafa;
        }
        .section-card-head h2 {
            font-size: .88rem;
            font-weight: 600;
        }
        .section-card-body { padding: 20px; }

        /* ── Form elements ── */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
        @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }

        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group.full { grid-column: 1 / -1; }

        label {
            font-size: .78rem;
            font-weight: 500;
            color: var(--muted);
        }
        input[type="text"],
        input[type="url"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            padding: 8px 11px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: .83rem;
            font-family: inherit;
            color: var(--text);
            background: var(--surface);
            outline: none;
            transition: border-color .15s;
            width: 100%;
        }
        input:focus, select:focus, textarea:focus { border-color: var(--accent); }
        input[type="file"] { padding: 6px 8px; cursor: pointer; }
        textarea { resize: vertical; min-height: 72px; }

        .toggle-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
        }
        .toggle {
            position: relative;
            width: 38px;
            height: 21px;
            flex-shrink: 0;
        }
        .toggle input { display: none; }
        .toggle-track {
            position: absolute;
            inset: 0;
            background: #d1d5db;
            border-radius: 20px;
            cursor: pointer;
            transition: background .2s;
        }
        .toggle input:checked + .toggle-track { background: var(--accent); }
        .toggle-track::after {
            content: '';
            position: absolute;
            top: 3px; left: 3px;
            width: 15px; height: 15px;
            background: #fff;
            border-radius: 50%;
            transition: transform .2s;
        }
        .toggle input:checked + .toggle-track::after { transform: translateX(17px); }
        .toggle-label { font-size: .82rem; color: var(--text); }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--radius);
            font-size: .8rem;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            border: none;
            transition: opacity .15s, transform .1s;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn:active { transform: scale(.98); }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { opacity: .88; }
        .btn-danger  { background: var(--danger); color: #fff; }
        .btn-danger:hover  { opacity: .88; }
        .btn-ghost {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text);
        }
        .btn-ghost:hover { background: var(--bg); }
        .btn-sm { padding: 5px 10px; font-size: .74rem; }
        .btn-icon { padding: 6px 8px; }

        /* ── Toast ── */
        #toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            padding: 10px 18px;
            border-radius: var(--radius);
            font-size: .82rem;
            font-weight: 500;
            color: #fff;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity .2s, transform .2s;
            pointer-events: none;
        }
        #toast.show { opacity: 1; transform: translateY(0); }
        #toast.success { background: var(--success); }
        #toast.error   { background: var(--danger); }

        /* ── Document table ── */
        .doc-table {
            width: 100%;
            border-collapse: collapse;
        }
        .doc-table th {
            font-size: .72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: var(--muted);
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
        }
        .doc-table td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-size: .82rem;
        }
        .doc-table tr:last-child td { border-bottom: none; }
        .doc-table tr:hover td { background: #f9fafb; }

        .status-pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: .7rem;
            font-weight: 600;
        }
        .status-active   { background: #dcfce7; color: #15803d; }
        .status-inactive { background: #f3f4f6; color: #6b7280; }

        .cat-tag {
            display: inline-block;
            padding: 2px 7px;
            background: #eff6ff;
            color: #1d4ed8;
            border-radius: 4px;
            font-size: .7rem;
            font-weight: 500;
        }

        .empty-row td {
            text-align: center;
            padding: 40px;
            color: var(--muted);
        }

        /* ── Modal ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal-overlay.open { display: flex; }
        .modal-box {
            background: var(--surface);
            border-radius: 12px;
            width: 100%;
            max-width: 560px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
        }
        .modal-head {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-head h3 { font-size: .95rem; font-weight: 600; }
        .modal-close {
            background: none;
            border: none;
            font-size: 1.1rem;
            color: var(--muted);
            cursor: pointer;
            padding: 2px 6px;
        }
        .modal-close:hover { color: var(--text); }
        .modal-body { padding: 20px; }
        .modal-foot {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        /* ── Confirm dialog ── */
        .confirm-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 1100;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .confirm-overlay.open { display: flex; }
        .confirm-box {
            background: var(--surface);
            border-radius: 12px;
            width: 100%;
            max-width: 380px;
            padding: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
            text-align: center;
        }
        .confirm-box i { font-size: 2rem; color: #fca5a5; margin-bottom: 12px; display: block; }
        .confirm-box h4 { font-size: .95rem; font-weight: 600; margin-bottom: 6px; }
        .confirm-box p  { font-size: .82rem; color: var(--muted); margin-bottom: 20px; }
        .confirm-actions { display: flex; gap: 8px; justify-content: center; }

        /* File drop zone */
        .drop-zone {
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: border-color .15s, background .15s;
            position: relative;
        }
        .drop-zone:hover, .drop-zone.dragover {
            border-color: var(--accent);
            background: #f0f6ff;
        }
        .drop-zone input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
        .drop-zone i { font-size: 1.4rem; color: #9ca3af; display: block; margin-bottom: 6px; }
        .drop-zone p { font-size: .78rem; color: var(--muted); }
        .drop-zone .file-chosen { font-size: .78rem; color: var(--accent); font-weight: 500; margin-top: 6px; }

        /* ── Order drag handle ── */
        .drag-handle {
            cursor: grab;
            color: #d1d5db;
            padding: 0 4px;
        }
        .drag-handle:hover { color: var(--muted); }

        @media (max-width: 700px) {
            .doc-table th:nth-child(3),
            .doc-table td:nth-child(3),
            .doc-table th:nth-child(4),
            .doc-table td:nth-child(4) { display: none; }
        }

        .nav-link {
            padding: 15px 22px;
        }
    </style>
</head>

<body>

<?php
// ── Constants ───────────────────────────────────────────────────────────────
// Adjust UPLOAD_DIR to match your project's absolute base path.
// Example: define('UPLOAD_DIR', '/var/www/html/mysite/');
// This should already be defined in your config/db include — add it there if so.
if (!defined('UPLOAD_DIR')) {
    define('UPLOAD_DIR', dirname(__FILE__) . '/');
}

// ── DB ──────────────────────────────────────────────────────────────────────
$conn = new mysqli("localhost", "root", "", "company_portal");
if ($conn->connect_error) {
    die('<p class="text-danger p-4">DB error: ' . htmlspecialchars($conn->connect_error) . '</p>');
}

// ── PDF Upload Helper ────────────────────────────────────────────────────────
/**
 * Uploads a PDF file and returns ['success' => bool, 'filename' => string, 'error' => string].
 *
 * @param  array  $fileArray   The $_FILES['field'] array.
 * @param  string $destDir     Absolute filesystem destination directory (with trailing slash).
 * @param  string $prefix      Optional filename prefix (e.g. 'kpj').
 * @return array
 */
function uploadPdf(array $fileArray, string $destDir, string $prefix = 'pdf'): array
{
    if ($fileArray['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'filename' => '', 'error' => 'Upload error code: ' . $fileArray['error']];
    }

    $ext = strtolower(pathinfo($fileArray['name'], PATHINFO_EXTENSION));
    if ($ext !== 'pdf') {
        return ['success' => false, 'filename' => '', 'error' => 'Only PDF files are allowed.'];
    }

    // Validate MIME type as a second safety check
    $finfo    = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $fileArray['tmp_name']);
    finfo_close($finfo);
    if ($mimeType !== 'application/pdf') {
        return ['success' => false, 'filename' => '', 'error' => 'Invalid file type. Only PDFs are accepted.'];
    }

    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }

    $safeName = preg_replace('/[^a-z0-9_-]/i', '_', pathinfo($fileArray['name'], PATHINFO_FILENAME));
    $filename = $prefix . '_' . $safeName . '_' . time() . '.pdf';
    $dest     = $destDir . $filename;

    if (!move_uploaded_file($fileArray['tmp_name'], $dest)) {
        return ['success' => false, 'filename' => '', 'error' => 'Failed to move uploaded file.'];
    }

    return ['success' => true, 'filename' => $filename, 'error' => ''];
}

// ── Handle POST actions ──────────────────────────────────────────────────────
$msg     = '';
$msgType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // ── Save button URL ──────────────────────────────────────────────────────
    if ($action === 'save_url') {
        $url  = trim($_POST['button_url'] ?? '');
        $stmt = $conn->prepare("
            INSERT INTO site_settings (`key`, `value`)
            VALUES ('kpj_button_url', ?)
            ON DUPLICATE KEY UPDATE `value` = ?
        ");
        $stmt->bind_param('ss', $url, $url);
        $stmt->execute();
        $stmt->close();
        $msg = 'Button URL saved.';
    }

    // ── Add / Edit PDF document ──────────────────────────────────────────────
    elseif ($action === 'save_doc') {
        $id       = intval($_POST['doc_id']         ?? 0);
        $title    = trim($_POST['title']            ?? '');
        $desc     = trim($_POST['description']      ?? '');
        $category = trim($_POST['category']         ?? '');
        $order    = intval($_POST['display_order']  ?? 0);
        $active   = isset($_POST['is_active'])       ? 1 : 0;

        // Start with whatever was previously stored (edit) or manual path (add)
        $filePath = trim($_POST['existing_file_path'] ?? '');

        // ── Handle PDF upload ────────────────────────────────────────────────
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {

            $publicDir = 'uploads/kpj/';              // relative path stored in DB
            $uploadDir = '/' . $publicDir;



            $upload = uploadPdf($_FILES['pdf_file'], UPLOAD_DIR . 'kpj/', 'kpj');
            if ($upload['success']) {
                $filePath = $publicDir . $upload['filename'];
            }
        }
        // ── Fallback: manual path field ──────────────────────────────────────
        elseif (!empty($_POST['file_path_manual'])) {
            $filePath = trim($_POST['file_path_manual']);
        }

        // Only proceed with DB write if no upload error occurred
        if (!$msg) {
            if ($id > 0) {
                // Update existing record
                $stmt = $conn->prepare("
                    UPDATE kpj
                    SET title = ?, description = ?, file_path = ?,
                        category = ?, display_order = ?, is_active = ?
                    WHERE id = ?
                ");
                $stmt->bind_param('ssssiis', $title, $desc, $filePath, $category, $order, $active, $id);
            } else {
                // Insert new record
                $stmt = $conn->prepare("
                    INSERT INTO kpj
                        (title, description, file_path, category, display_order, is_active)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                $stmt->bind_param('ssssii', $title, $desc, $filePath, $category, $order, $active);
            }
            $stmt->execute();
            $stmt->close();
            $msg = $id > 0 ? 'Document updated.' : 'Document added.';
        }
    }

    // ── Delete document ──────────────────────────────────────────────────────
    elseif ($action === 'delete_doc') {
        $id = intval($_POST['doc_id'] ?? 0);
        if ($id > 0) {
            $stmt = $conn->prepare("DELETE FROM kpj WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
            $msg = 'Document deleted.';
        }
    }

    // ── Toggle active (AJAX) ─────────────────────────────────────────────────
    elseif ($action === 'toggle_active') {
        $id  = intval($_POST['doc_id'] ?? 0);
        $val = intval($_POST['value']  ?? 0);
        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE kpj SET is_active = ? WHERE id = ?");
            $stmt->bind_param('ii', $val, $id);
            $stmt->execute();
            $stmt->close();
            echo json_encode(['ok' => true]);
            exit;
        }
    }

    // ── Save display order (AJAX) ────────────────────────────────────────────
    elseif ($action === 'save_order') {
        $ids = json_decode($_POST['order'] ?? '[]', true);
        foreach ($ids as $pos => $docId) {
            $stmt = $conn->prepare("UPDATE kpj SET display_order = ? WHERE id = ?");
            $o = $pos + 1;
            $stmt->bind_param('ii', $o, $docId);
            $stmt->execute();
            $stmt->close();
        }
        echo json_encode(['ok' => true]);
        exit;
    }
}

// ── Fetch current data ───────────────────────────────────────────────────────

// Button URL from settings
$urlResult = $conn->query("SELECT `value` FROM site_settings WHERE `key` = 'kpj_button_url' LIMIT 1");
$buttonUrl = ($urlResult && $urlResult->num_rows)
    ? $urlResult->fetch_assoc()['value']
    : 'https://kpjhealthsystem.com.my/';

// All documents
$docs = $conn->query("
    SELECT * FROM kpj ORDER BY display_order ASC, uploaded_at DESC
")->fetch_all(MYSQLI_ASSOC);

// Unique categories for datalist
$categories = array_values(array_unique(
    array_filter(array_column($docs, 'category'))
));

$conn->close();
?>


<!-- Breadcrumb -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width:900px;">
        <h3 class="text-white display-3 mb-3 wow fadeInDown" data-wow-delay="0.1s">KPJ ADMIN</h3>
        <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s"></ol>
    </div>
</div>

<div class="page-wrap">

    <!-- Header -->
    <div class="page-header" data-aos="fade-up">
        <h1>KPJ Health System — Page Manager</h1>
        <p>Manage the external button URL and PDF document library</p>
    </div>

    <!-- ── Section 1: Button URL ── -->
    <div class="section-card" data-aos="fade-up" data-aos-delay="50">
        <div class="section-card-head">
            <h2><i class="fas fa-link" style="color:var(--accent); margin-right:8px;"></i>External Button URL</h2>
        </div>
        <div class="section-card-body">
            <form method="POST">
                <input type="hidden" name="action" value="save_url">
                <div class="form-group" style="margin-bottom:14px;">
                    <label>KPJ Health System Button URL</label>
                    <input type="url" name="button_url"
                           value="<?= htmlspecialchars($buttonUrl) ?>"
                           placeholder="https://kpjhealthsystem.com.my/"
                           required>
                    <span style="font-size:.72rem; color:var(--muted); margin-top:3px;">
                        This URL is used for the "KPJ Health System" button on the public page.
                    </span>
                </div>
                <div style="display:flex; align-items:center; gap:10px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save URL
                    </button>
                    <a href="<?= htmlspecialchars($buttonUrl) ?>" target="_blank"
                       class="btn btn-ghost">
                        <i class="fas fa-external-link-alt"></i> Open Link
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- ── Section 2: PDF Documents ── -->
    <div class="section-card" data-aos="fade-up" data-aos-delay="80">
        <div class="section-card-head">
            <h2><i class="fas fa-file-pdf" style="color:#dc2626; margin-right:8px;"></i>PDF Documents</h2>
            <button class="btn btn-primary btn-sm" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Add Document
            </button>
        </div>

        <div style="overflow-x:auto;">
            <table class="doc-table" id="docTable">
                <thead>
                    <tr>
                        <th style="width:32px;"></th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>File Path</th>
                        <th style="width:80px;">Order</th>
                        <th style="width:80px;">Status</th>
                        <th style="width:100px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="docTableBody">
                    <?php if (empty($docs)): ?>
                        <tr class="empty-row">
                            <td colspan="7">
                                <i class="fas fa-folder-open" style="font-size:1.4rem; color:#d1d5db; display:block; margin-bottom:8px;"></i>
                                No documents yet. Click <strong>Add Document</strong> to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($docs as $doc): ?>
                        <tr data-id="<?= $doc['id'] ?>">
                            <td>
                                <span class="drag-handle" title="Drag to reorder">
                                    <i class="fas fa-grip-vertical"></i>
                                </span>
                            </td>
                            <td>
                                <div style="font-weight:500;"><?= htmlspecialchars($doc['title']) ?></div>
                                <?php if (!empty($doc['description'])): ?>
                                    <div style="font-size:.72rem; color:var(--muted); margin-top:2px;">
                                        <?= htmlspecialchars(mb_strimwidth($doc['description'], 0, 60, '…')) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($doc['category'])): ?>
                                    <span class="cat-tag"><?= htmlspecialchars($doc['category']) ?></span>
                                <?php else: ?>
                                    <span style="color:var(--muted);">—</span>
                                <?php endif; ?>
                            </td>
                            <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; color:var(--muted);">
                                <span title="<?= htmlspecialchars($doc['file_path']) ?>">
                                    <?= htmlspecialchars($doc['file_path']) ?>
                                </span>
                            </td>
                            <td style="text-align:center; color:var(--muted);">
                                <?= (int)$doc['display_order'] ?>
                            </td>
                            <td>
                                <label class="toggle" title="Toggle active">
                                    <input type="checkbox"
                                           <?= $doc['is_active'] ? 'checked' : '' ?>
                                           onchange="toggleActive(<?= $doc['id'] ?>, this.checked ? 1 : 0)">
                                    <span class="toggle-track"></span>
                                </label>
                            </td>
                            <td>
                                <div style="display:flex; gap:6px;">
                                    <button class="btn btn-ghost btn-icon btn-sm"
                                            title="Edit"
                                            onclick='openEditModal(<?= json_encode($doc) ?>)'>
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div><!-- /page-wrap -->

<!-- ── Add / Edit Modal ── -->
<div class="modal-overlay" id="docModal">
    <div class="modal-box">
        <div class="modal-head">
            <h3 id="modalTitle">Add Document</h3>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <form method="POST" enctype="multipart/form-data" id="docForm">
            <input type="hidden" name="action" value="save_doc">
            <input type="hidden" name="doc_id" id="docId" value="0">
            <input type="hidden" name="existing_file_path" id="existingFilePath" value="">

            <div class="modal-body">
                <div class="form-row" style="margin-bottom:14px;">
                    <div class="form-group full">
                        <label>Title <span style="color:var(--danger);">*</span></label>
                        <input type="text" name="title" id="fTitle"
                               placeholder="e.g. Staff Handbook 2025" required>
                    </div>
                </div>

                <div class="form-row" style="margin-bottom:14px;">
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" name="category" id="fCategory"
                               list="catList" placeholder="e.g. HR, Policy, Guide">
                        <datalist id="catList">
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= htmlspecialchars($c) ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label>Display Order</label>
                        <input type="number" name="display_order" id="fOrder"
                               value="0" min="0">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:14px;">
                    <label>Description</label>
                    <textarea name="description" id="fDesc"
                              placeholder="Short description (optional)"></textarea>
                </div>

                <!-- PDF Upload / file path -->
                <div class="form-group" style="margin-bottom:14px;">
                    <label>PDF File</label>
                    <div class="drop-zone" id="dropZone">
                        <input type="file" name="pdf_file" id="pdfFileInput"
                               accept=".pdf" onchange="handleFileChosen(this)">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Click to upload or drag & drop a PDF</p>
                        <div class="file-chosen" id="fileChosen" style="display:none;"></div>
                    </div>
                    <div id="existingFileWrap" style="display:none; margin-top:8px;">
                        <span style="font-size:.75rem; color:var(--muted);">Current file: </span>
                        <span id="existingFileLabel" style="font-size:.75rem; color:var(--accent);"></span>
                        <span style="font-size:.75rem; color:var(--muted);"> — upload a new file to replace it</span>
                    </div>

                    <div style="margin-top:10px;">
                        <label style="margin-bottom:4px;">— or enter file path manually —</label>
                        <input type="text" name="file_path_manual" id="fFilePath"
                               placeholder="uploads/pdfs/filename.pdf">
                    </div>
                </div>

                <div class="toggle-wrap">
                    <label class="toggle">
                        <input type="checkbox" name="is_active" id="fActive" checked>
                        <span class="toggle-track"></span>
                    </label>
                    <span class="toggle-label">Active (visible on public page)</span>
                </div>
            </div>

            <div class="modal-foot">
                <button type="button" class="btn btn-ghost" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <span id="saveLabel">Add Document</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ── Confirm Delete ── -->
<div class="confirm-overlay" id="confirmOverlay">
    <div class="confirm-box">
        <i class="fas fa-exclamation-triangle"></i>
        <h4>Delete Document?</h4>
        <p id="confirmText">This will permanently remove the record from the database.</p>
        <div class="confirm-actions">
            <button class="btn btn-ghost" onclick="closeConfirm()">Cancel</button>
            <form method="POST" id="deleteForm" style="display:inline;">
                <input type="hidden" name="action" value="delete_doc">
                <input type="hidden" name="doc_id" id="deleteDocId" value="">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Toast -->
<div id="toast"></div>



<a href="#" class="btn btn-primary btn-lg-square back-to-top">
    <i class="fa fa-arrow-up"></i>
</a>

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script src="js/main.js"></script>

<script>
    AOS.init({ duration: 380, offset: 40, once: true });

    // ── Toast ─────────────────────────────────────────────────────────────
    <?php if ($msg): ?>
    showToast(<?= json_encode($msg) ?>, '<?= $msgType ?>');
    <?php endif; ?>

    function showToast(msg, type = 'success') {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.className   = 'show ' + type;
        setTimeout(() => { t.className = ''; }, 3200);
    }

    // ── Add modal ─────────────────────────────────────────────────────────
    function openAddModal() {
        document.getElementById('modalTitle').textContent      = 'Add Document';
        document.getElementById('saveLabel').textContent       = 'Add Document';
        document.getElementById('docId').value                 = '0';
        document.getElementById('existingFilePath').value      = '';
        document.getElementById('fTitle').value                = '';
        document.getElementById('fCategory').value             = '';
        document.getElementById('fDesc').value                 = '';
        document.getElementById('fOrder').value                = '0';
        document.getElementById('fFilePath').value             = '';
        document.getElementById('fActive').checked             = true;
        document.getElementById('fileChosen').style.display    = 'none';
        document.getElementById('existingFileWrap').style.display = 'none';
        // Reset file input
        document.getElementById('pdfFileInput').value          = '';
        document.getElementById('docModal').classList.add('open');
    }

    // ── Edit modal ────────────────────────────────────────────────────────
    function openEditModal(doc) {
        document.getElementById('modalTitle').textContent      = 'Edit Document';
        document.getElementById('saveLabel').textContent       = 'Save Changes';
        document.getElementById('docId').value                 = doc.id;
        document.getElementById('existingFilePath').value      = doc.file_path || '';
        document.getElementById('fTitle').value                = doc.title        || '';
        document.getElementById('fCategory').value             = doc.category     || '';
        document.getElementById('fDesc').value                 = doc.description  || '';
        document.getElementById('fOrder').value                = doc.display_order || 0;
        document.getElementById('fFilePath').value             = doc.file_path    || '';
        document.getElementById('fActive').checked             = doc.is_active == 1;
        document.getElementById('fileChosen').style.display    = 'none';
        // Reset file input so stale selection doesn't override existing file
        document.getElementById('pdfFileInput').value          = '';

        if (doc.file_path) {
            document.getElementById('existingFileLabel').textContent  = doc.file_path;
            document.getElementById('existingFileWrap').style.display = 'block';
        } else {
            document.getElementById('existingFileWrap').style.display = 'none';
        }

        document.getElementById('docModal').classList.add('open');
    }

    function closeModal() {
        document.getElementById('docModal').classList.remove('open');
    }

    // Close modal on overlay click
    document.getElementById('docModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    // ── File chosen label ─────────────────────────────────────────────────
    function handleFileChosen(input) {
        const el = document.getElementById('fileChosen');
        if (input.files.length) {
            el.textContent = '📄 ' + input.files[0].name;
            el.style.display = 'block';
            // Clear manual path when a file is selected — avoid ambiguity
            document.getElementById('fFilePath').value        = '';
            document.getElementById('existingFilePath').value = '';
        } else {
            el.style.display = 'none';
        }
    }

    // ── Drag & drop on drop zone ──────────────────────────────────────────
    const dz = document.getElementById('dropZone');
    dz.addEventListener('dragover',  e => { e.preventDefault(); dz.classList.add('dragover'); });
    dz.addEventListener('dragleave', () => dz.classList.remove('dragover'));
    dz.addEventListener('drop', e => {
        e.preventDefault();
        dz.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length) {
            const input = document.getElementById('pdfFileInput');
            // Use DataTransfer to assign dropped files to the input
            const dt = new DataTransfer();
            dt.items.add(files[0]);
            input.files = dt.files;
            handleFileChosen(input);
        }
    });

    // ── Confirm delete ────────────────────────────────────────────────────
    function confirmDelete(id, title) {
        document.getElementById('deleteDocId').value = id;
        document.getElementById('confirmText').textContent =
            `"${title}" will be permanently removed from the database.`;
        document.getElementById('confirmOverlay').classList.add('open');
    }
    function closeConfirm() {
        document.getElementById('confirmOverlay').classList.remove('open');
    }
    document.getElementById('confirmOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeConfirm();
    });

    // ── Toggle active via AJAX ────────────────────────────────────────────
    function toggleActive(id, value) {
        const fd = new FormData();
        fd.append('action', 'toggle_active');
        fd.append('doc_id', id);
        fd.append('value',  value);
        fetch('', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(d => { if (d.ok) showToast('Status updated.'); })
            .catch(() => showToast('Update failed.', 'error'));
    }

    // ── Sortable rows — drag to reorder ───────────────────────────────────
    const tbody = document.getElementById('docTableBody');
    if (tbody && typeof Sortable !== 'undefined') {
        Sortable.create(tbody, {
            handle: '.drag-handle',
            animation: 140,
            onEnd: function () {
                const ids = Array.from(tbody.querySelectorAll('tr[data-id]'))
                    .map(tr => tr.dataset.id);
                const fd = new FormData();
                fd.append('action', 'save_order');
                fd.append('order',  JSON.stringify(ids));
                fetch('', { method: 'POST', body: fd })
                    .then(r => r.json())
                    .then(d => { if (d.ok) showToast('Order saved.'); })
                    .catch(() => showToast('Failed to save order.', 'error'));
            }
        });
    }
</script>

</body>
</html>