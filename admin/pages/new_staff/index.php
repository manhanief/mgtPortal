<?php
$staff = getTableData($db, 'onboarding', 'is_active', 'ASC');
?>

<section class="content-section">
    <div class="section-header">
        <h2>Onboarding Staff</h2>
        <button class="btn-add" onclick="openStaffModal()">+ Add Staff</button>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No#</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>is_active</th>
                    <th>Update Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($staff as $staff): ?>
                <tr>
                    <td><span class="badge" style="background: #3498db; color: white;">#<?= $staff['id'] ?></span></td>
                    <td><?= $staff['name'] ?></td>
                    <td>
                        <?php if ($staff['image_path']): ?>
                            <img src="../<?= htmlspecialchars($staff['image_path']) ?>" class="table-thumb">
                            <?php else: ?>
                                <span class="no-image-badge">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge <?= $staff['is_active'] ? 'badge-active' : 'badge-inactive' ?>">
                                    <?= $staff['is_active'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($staff['update_at']) ?></td>
                    <td>
                        <button class="btn-icon btn-edit" onclick="editStaff(<?= $staff['id'] ?>)" title="Edit">✏️</button>
                        <button class="btn-icon btn-delete" onclick="deleteStaff(<?= $staff['id'] ?>)" title="Delete">🗑️</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal -->
<div id="staffModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeStaffModal()">&times;</span>
        <h3 id="staffModalTitle">Add Staff</h3>
        
        <form id="staffForm" enctype="multipart/form-data">
            <input type="hidden" id="staffId" name="id">
            
            <div class="form-group">
                <label>Name: *</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Image/Thumbnail:</label>
                <input type="file" name="image" accept="image/*">
            </div>
            

            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" checked> Active
                </label>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-save">Save</button>
                <button type="button" class="btn-cancel" onclick="closeStaffModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openStaffModal() {
    document.getElementById('staffModal').style.display = 'block';
    document.getElementById('staffModalTitle').textContent = 'Add Staff';
    document.getElementById('staffForm').reset();
    document.getElementById('staffId').value = '';
}

function closeStaffModal() {
    document.getElementById('staffModal').style.display = 'none';
}

function editStaff(id) {
    fetch(`controllers/staff.php?action=get&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const staff = data.data;
                document.getElementById('staffId').value = staff.id;
                document.querySelector('[name="name"]').value = staff.name || '';
                document.querySelector('[name="is_active"]').checked = staff.is_active == 1;
                
                document.getElementById('staffModalTitle').textContent = 'Edit Staff';
                document.getElementById('staffModal').style.display = 'block';
            }
        });
}

function deleteStaff(id) {
    if (!confirm('Delete this staff member?')) return;
    
    fetch('controllers/staff.php', {
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

document.getElementById('staffForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    formData.append('action', document.getElementById('staffId').value ? 'update' : 'create');
    
    const response = await fetch('controllers/staff.php', {
        method: 'POST',
        body: formData
    });
    
    const result = await response.json();
    if (result.success) location.reload();
    else alert(result.error);
});
</script>