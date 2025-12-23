<?php
$systems = getTableData($db, 'systems', 'display_order', 'ASC');
?>

<section class="content-section">
    <div class="section-header">
        <h2>🔗 Manage Systems & Services</h2>
        <button class="btn-add" onclick="openSystemModal()">+ Add New System</button>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Icon</th>
                    <th>Title</th>
                    <th>Services</th>
                    <th>Link URL</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($systems as $system): ?>
                <tr>
                    <td><?= $system['display_order'] ?></td>
                    <td>
                        <?php if ($system['icon_path']): ?>
                            <img src="../<?= htmlspecialchars($system['icon_path']) ?>" class="table-thumb">
                        <?php else: ?>
                            <span class="no-image-badge">No Icon</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($system['title']) ?></td>
                    <td><?= truncateText($system['services'], 50) ?></td>
                    <td><a href="<?= htmlspecialchars($system['link_url']) ?>" target="_blank" class="link-preview"><?= truncateText($system['link_url'], 30) ?></a></td>
                    <td>
                        <span class="badge <?= $system['is_active'] ? 'badge-active' : 'badge-inactive' ?>">
                            <?= $system['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td>
                        <button class="btn-icon btn-edit" onclick="editSystem(<?= $system['id'] ?>)" title="Edit">✏️</button>
                        <button class="btn-icon btn-delete" onclick="deleteSystem(<?= $system['id'] ?>)" title="Delete">🗑️</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal -->
<div id="systemModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeSystemModal()">&times;</span>
        <h3 id="systemModalTitle">Add New System</h3>
        
        <form id="systemForm" enctype="multipart/form-data">
            <input type="hidden" id="systemId" name="id">
            
            <div class="form-group">
                <label>Title: *</label>
                <input type="text" name="title" required>
            </div>
            
            <div class="form-group">
                <label>Services:</label>
                <textarea name="services" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>Link URL: *</label>
                <input type="url" name="link_url" required placeholder="https://example.com">
            </div>
            
            <div class="form-group">
                <label>Icon Image:</label>
                <input type="file" name="icon" accept="image/*">
                <small>Max 5MB. JPG, PNG, GIF, WebP</small>
            </div>
            
            <div class="form-group">
                <label>Display Order:</label>
                <input type="number" name="display_order" value="0" min="0">
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" checked> Active
                </label>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-save">Save</button>
                <button type="button" class="btn-cancel" onclick="closeSystemModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script src="assets/systems-script.js"></script>