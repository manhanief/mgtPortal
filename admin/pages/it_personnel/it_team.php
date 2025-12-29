<?php
$itTeam = getTableData($db, 'it_team', 'display_order', 'ASC');
?>

<section class="content-section">
    <div class="section-header">
        <h2>💻 IT Team Members</h2>
        <button class="btn-add" onclick="openITModal()">+ Add Team Member</button>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Email</th>
                    <th>Extension</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($itTeam as $member): ?>
                <tr>
                    <td>
                        <?php if ($member['image_path']): ?>
                            <img src="../<?= htmlspecialchars($member['image_path']) ?>" class="table-thumb" style="border-radius: 50%;">
                        <?php else: ?>
                            <span class="no-image-badge">No Photo</span>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= htmlspecialchars($member['name']) ?></strong></td>
                    <td><?= htmlspecialchars($member['position']) ?></td>
                    <td><a href="mailto:<?= htmlspecialchars($member['email']) ?>"><?= htmlspecialchars($member['email']) ?></a></td>
                    <td><?= htmlspecialchars($member['extension_no']) ?></td>
                    <td>
                        <span class="badge <?= $member['is_active'] ? 'badge-active' : 'badge-inactive' ?>">
                            <?= $member['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td>
                        <button class="btn-icon btn-edit" onclick="editITMember(<?= $member['id'] ?>)" title="Edit">✏️</button>
                        <button class="btn-icon btn-delete" onclick="deleteITMember(<?= $member['id'] ?>)" title="Delete">🗑️</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal -->
<div id="itModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeITModal()">&times;</span>
        <h3 id="itModalTitle">Add IT Team Member</h3>
        
        <form id="itForm" enctype="multipart/form-data">
            <input type="hidden" id="itId" name="id">
            
            <div class="form-group">
                <label>Name: *</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Position: *</label>
                <input type="text" name="position" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email">
            </div>
            
            <div class="form-group">
                <label>Extension Number:</label>
                <input type="text" name="extension_no">
            </div>
            
            <div class="form-group">
                <label>Photo:</label>
                <input type="file" name="image" accept="image/*">
                <small>Professional photo recommended</small>
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
                <button type="button" class="btn-cancel" onclick="closeITModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openITModal() {
    document.getElementById('itModal').style.display = 'block';
    document.getElementById('itModalTitle').textContent = 'Add IT Team Member';
    document.getElementById('itForm').reset();
    document.getElementById('itId').value = '';
}

function closeITModal() {
    document.getElementById('itModal').style.display = 'none';
}

function editITMember(id) {
    fetch(`controllers/it_team.php?action=get&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const member = data.data;
                document.getElementById('itId').value = member.id;
                document.querySelector('[name="name"]').value = member.name;
                document.querySelector('[name="position"]').value = member.position;
                document.querySelector('[name="email"]').value = member.email || '';
                document.querySelector('[name="extension_no"]').value = member.extension_no || '';
                document.querySelector('[name="display_order"]').value = member.display_order;
                document.querySelector('[name="is_active"]').checked = member.is_active == 1;
                
                document.getElementById('itModalTitle').textContent = 'Edit ' + member.name;
                document.getElementById('itModal').style.display = 'block';
            }
        });
}

function deleteITMember(id) {
    if (!confirm('Delete this team member?')) return;
    
    fetch('controllers/it_team.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=delete&id=${id}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.error);
        }
    });
}

document.getElementById('itForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    formData.append('action', document.getElementById('itId').value ? 'update' : 'create');
    
    const response = await fetch('controllers/it_team.php', {
        method: 'POST',
        body: formData
    });
    
    const result = await response.json();
    
    if (result.success) {
        location.reload();
    } else {
        alert(result.error);
    }
});
</script>