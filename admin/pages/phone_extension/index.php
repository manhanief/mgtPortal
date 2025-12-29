<?php
$extensions = getTableData($db, 'extensions', 'display_order', 'ASC');
?>

<section class="content-section">
    <div class="section-header">
        <h2>📞 Extensions Directory</h2>
        <button class="btn-add" onclick="openExtModal()">+ Add Extension</button>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Title/Name</th>
                    <th>Service</th>
                    <th>Room No</th>
                    <th>Clinic No</th>
                    <th>Extension</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($extensions as $ext): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($ext['title']) ?></strong></td>
                    <td><?= htmlspecialchars($ext['service']) ?></td>
                    <td><?= htmlspecialchars($ext['room_no']) ?></td>
                    <td><?= htmlspecialchars($ext['clinic_no']) ?></td>
                    <td><code><?= htmlspecialchars($ext['extension_no']) ?></code></td>
                    <td><?= htmlspecialchars($ext['department']) ?></td>
                    <td>
                        <span class="badge <?= $ext['is_active'] ? 'badge-active' : 'badge-inactive' ?>">
                            <?= $ext['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td>
                        <button class="btn-icon btn-edit" onclick="editExt(<?= $ext['id'] ?>)" title="Edit">✏️</button>
                        <button class="btn-icon btn-delete" onclick="deleteExt(<?= $ext['id'] ?>)" title="Delete">🗑️</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal -->
<div id="extModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeExtModal()">&times;</span>
        <h3 id="extModalTitle">Add Extension</h3>
        
        <form id="extForm">
            <input type="hidden" id="extId" name="id">
            
            <div class="form-group">
                <label>Title/Name: *</label>
                <input type="text" name="title" required>
            </div>
            
            <div class="form-group">
                <label>Service:</label>
                <input type="text" name="service">
            </div>
            
            <div class="form-group">
                <label>Room Number:</label>
                <input type="text" name="room_no">
            </div>
            
            <div class="form-group">
                <label>Clinic Number:</label>
                <input type="text" name="clinic_no">
            </div>
            
            <div class="form-group">
                <label>Extension Number:</label>
                <input type="text" name="extension_no">
            </div>
            
            <div class="form-group">
                <label>Department:</label>
                <input type="text" name="department">
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
                <button type="button" class="btn-cancel" onclick="closeExtModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openExtModal() {
    document.getElementById('extModal').style.display = 'block';
    document.getElementById('extModalTitle').textContent = 'Add Extension';
    document.getElementById('extForm').reset();
    document.getElementById('extId').value = '';
}

function closeExtModal() {
    document.getElementById('extModal').style.display = 'none';
}

function editExt(id) {
    fetch(`controllers/extension.php?action=get&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const ext = data.data;
                document.getElementById('extId').value = ext.id;
                document.querySelector('[name="title"]').value = ext.title;
                document.querySelector('[name="service"]').value = ext.service || '';
                document.querySelector('[name="room_no"]').value = ext.room_no || '';
                document.querySelector('[name="clinic_no"]').value = ext.clinic_no || '';
                document.querySelector('[name="extension_no"]').value = ext.extension_no || '';
                document.querySelector('[name="department"]').value = ext.department || '';
                document.querySelector('[name="display_order"]').value = ext.display_order;
                document.querySelector('[name="is_active"]').checked = ext.is_active == 1;
                
                document.getElementById('extModalTitle').textContent = 'Edit Extension';
                document.getElementById('extModal').style.display = 'block';
            }
        });
}

function deleteExt(id) {
    if (!confirm('Delete this extension?')) return;
    
    fetch('controllers/extension.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=delete&id=${id}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) location.reload();
        else alert(data.error);
    });
}

document.getElementById('extForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    formData.append('action', document.getElementById('extId').value ? 'update' : 'create');
    
    const response = await fetch('controllers/extension.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(formData)
    });
    
    const result = await response.json();
    if (result.success) location.reload();
    else alert(result.error);
});
</script>