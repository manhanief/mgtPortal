<?php
require_once __DIR__ . '/../controllers/navigationController.php';

NavigationController::init();
$data = NavigationController::handleRequest();

$navigationItems = $data['navigationItems'];
$message         = $data['message'];
$messageType     = $data['messageType'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <style>
        :root {
            --accent:  #2563eb;
            --surface: #ffffff;
            --bg:      #f8f9fb;
            --border:  #e5e7eb;
            --text:    #111827;
            --muted:   #6b7280;
            --radius:  8px;
            --success: #16a34a;
            --danger:  #dc2626;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 48px 20px 80px;
        }

        .page {
            width: 100%;
            max-width: 680px;
        }

        /* ── Header ── */
        .page-header {
            margin-bottom: 24px;
        }
        .page-header h1 {
            font-size: 1.25rem;
            font-weight: 600;
            letter-spacing: -.3px;
        }
        .page-header p {
            font-size: .81rem;
            color: var(--muted);
            margin-top: 4px;
        }

        /* ── Alert ── */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 16px;
            border-radius: var(--radius);
            font-size: .82rem;
            font-weight: 500;
            margin-bottom: 20px;
        }
        .alert-success { background: #f0fdf4; color: var(--success); border: 1px solid #bbf7d0; }
        .alert-danger  { background: #fef2f2; color: var(--danger);  border: 1px solid #fecaca; }

        /* ── Card ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .card-head {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-head span {
            font-size: .72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--muted);
        }
        .item-count {
            background: #eff6ff;
            color: var(--accent);
            border-radius: 20px;
            padding: 2px 9px;
            font-size: .71rem;
            font-weight: 600;
        }

        /* ── Nav row ── */
        .nav-row {
            display: grid;
            grid-template-columns: 1fr 110px 90px;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            border-bottom: 1px solid var(--border);
            transition: background .12s;
        }
        .nav-row:last-child { border-bottom: none; }
        .nav-row:hover { background: #fafafa; }

                            /* Column headers */
        .nav-head {
            background: #fafafa;
            padding: 8px 20px;
            border-bottom: 1px solid var(--border);
        }
        .nav-head-inner {
            display: grid;
            grid-template-columns: 1fr 110px 90px;
            gap: 12px;
        }
        .col-label {
            font-size: .7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: var(--muted);
        }

        /* ── Inputs ── */
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 7px 10px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: .82rem;
            font-family: inherit;
            color: var(--text);
            background: var(--surface);
            outline: none;
            transition: border-color .15s;
        }
        input[type="text"]:focus,
        input[type="number"]:focus { border-color: var(--accent); }
        input[type="number"] { text-align: center; }

        /* ── Toggle switch ── */
        .toggle-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .toggle {
            position: relative;
            width: 38px;
            height: 22px;
            flex-shrink: 0;
        }
        .toggle input { display: none; }
        .toggle-track {
            position: absolute;
            inset: 0;
            background: #d1d5db;
            border-radius: 20px;
            cursor: pointer;
            transition: background .18s;
        }
        .toggle input:checked + .toggle-track { background: var(--accent); }
        .toggle-track::after {
            content: '';
            position: absolute;
            top: 3px; left: 3px;
            width: 16px; height: 16px;
            background: #fff;
            border-radius: 50%;
            transition: transform .18s;
            box-shadow: 0 1px 3px rgba(0,0,0,.15);
        }
        .toggle input:checked + .toggle-track::after { transform: translateX(16px); }
        .toggle-status {
            font-size: .75rem;
            font-weight: 500;
            width: 44px;
        }
        .toggle-status.on  { color: var(--accent); }
        .toggle-status.off { color: var(--muted);  }

        /* ── Footer / save button ── */
        .card-foot {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: var(--radius);
            font-size: .82rem;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            transition: opacity .15s, transform .1s;
        }
        .btn-save:hover   { opacity: .88; }
        .btn-save:active  { transform: scale(.98); }

        .save-hint {
            font-size: .75rem;
            color: var(--muted);
        }

        /* ── Empty state ── */
        .empty {
            text-align: center;
            padding: 40px 20px;
            color: var(--muted);
        }
        .empty i { font-size: 1.6rem; display: block; margin-bottom: 8px; color: #d1d5db; }

        @media (max-width: 480px) {
            .nav-row,
            .nav-head-inner { grid-template-columns: 1fr 80px 70px; gap: 8px; }
            .nav-row { padding: 10px 14px; }
            .nav-head { padding: 7px 14px; }
            .card-foot { padding: 12px 14px; }
        }

        .nav-link{
            padding: 15px 23px;
        }
    </style>
</head>
<body>

<div class=" ">

    <!-- Header -->
    <div class="page-header">
        <h1>Navigation Settings</h1>
        <p>Edit display names, visibility, and order for navigation items</p>
    </div>

    <!-- Alert -->
    <?php if ($message): ?>
        <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'danger' ?>">
            <i class="fas fa-<?= $messageType === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <!-- Card -->
    <div class="card " >

        <div class="card-head">
            <span>Menu Items</span>
            <span class="item-count"><?= count($navigationItems) ?> items</span>
        </div>

        <form method="post">

            <?php if (empty($navigationItems)): ?>
                <div class="empty">
                    <i class="fas fa-compass"></i>
                    No navigation items found.
                </div>
            <?php else: ?>

                <!-- Column labels -->
                <div class="nav-head">
                    <div class="nav-head-inner">
                        <span class="col-label">Display Name</span>
                        <span class="col-label">Visibility</span>
                        <span class="col-label" style="text-align:center;">Order</span>
                    </div>
                </div>

                <!-- Rows -->
                <?php foreach ($navigationItems as $item): ?>
                <div class="nav-row">

                    <!-- Name -->
                    <input type="text"
                           name="navigation[<?= $item['id'] ?>][display_name]"
                           value="<?= htmlspecialchars($item['display_name']) ?>"
                           placeholder="Label…">

                    <!-- Visible toggle -->
                    <div class="toggle-wrap">
                        <label class="toggle">
                            <input type="checkbox"
                                   name="navigation[<?= $item['id'] ?>][is_visible]"
                                   value="1"
                                   <?= $item['is_visible'] ? 'checked' : '' ?>
                                   onchange="updateLabel(this)">
                            <span class="toggle-track"></span>
                        </label>
                        <span class="toggle-status <?= $item['is_visible'] ? 'on' : 'off' ?>">
                            <?= $item['is_visible'] ? 'Visible' : 'Hidden' ?>
                        </span>
                    </div>

                    <!-- Order -->
                    <input type="number"
                           name="navigation[<?= $item['id'] ?>][display_order]"
                           value="<?= $item['display_order'] ?>"
                           min="0">

                </div>
                <?php endforeach; ?>

            <?php endif; ?>

            <!-- Footer -->
            <div class="card-foot">
                <span class="save-hint">Changes apply immediately after saving</span>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>

        </form>
    </div>

</div><!-- /page -->

<script>
    function updateLabel(checkbox) {
        const status = checkbox.closest('.toggle-wrap').querySelector('.toggle-status');
        if (checkbox.checked) {
            status.textContent = 'Visible';
            status.className   = 'toggle-status on';
        } else {
            status.textContent = 'Hidden';
            status.className   = 'toggle-status off';
        }
    }
</script>

</body>
</html>