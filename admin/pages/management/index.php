<?php
$topManagement = getTableData($db, 'top_management', 'display_order', 'ASC');
$boardDirectors = getTableData($db, 'board_directors', 'display_order', 'ASC');
$seniorManagement = getTableData($db, 'senior_management', 'display_order', 'ASC');
?>

<section class="content-section">
    <h2>👔 Management Teams</h2>
    
    <!-- Tabs -->
    <div class="tabs">
        <button class="tab-btn active" onclick="showTab('top')">Top Management (<?= count($topManagement) ?>)</button>
        <button class="tab-btn" onclick="showTab('board')">Board of Directors (<?= count($boardDirectors) ?>)</button>
        <button class="tab-btn" onclick="showTab('senior')">Senior Management (<?= count($seniorManagement) ?>)</button>
    </div>
    
    <!-- Top Management Tab -->
    <div id="top-tab" class="tab-content active">
        <div class="section-header" style="margin-bottom: 20px;">
            <h3 style="margin: 0;">Top Management Team</h3>
            <button class="btn-add" onclick="addManagement('top_management')">+ Add Member</button>
        </div>
        <div class="management-grid">
            <?php foreach ($topManagement as $member): ?>
                <div class="management-card">
                    <button class="delete-badge" onclick="deleteManagement('top_management', <?= $member['id'] ?>, '<?= htmlspecialchars($member['name']) ?>')" title="Delete">×</button>
                    <div class="card-image">
                        <?php if ($member['image_path']): ?>
                            <img src="../<?= htmlspecialchars($member['image_path']) ?>">
                        <?php else: ?>
                            <div class="no-image-placeholder">👤</div>
                        <?php endif; ?>
                    </div>
                    <div class="card-info">
                        <h4><?= htmlspecialchars($member['name']) ?></h4>
                        <p><?= htmlspecialchars($member['position']) ?></p>
                    </div>
                    <button class="btn-edit-card" onclick="editManagement('top_management', <?= $member['id'] ?>)">✏️ Edit</button>
                </div>
            <?php endforeach; ?>
            
            <?php if (empty($topManagement)): ?>
                <div class="empty-state">
                    <p>No members added yet</p>
                    <button class="btn-add" onclick="addManagement('top_management')">+ Add First Member</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Board Directors Tab -->
    <div id="board-tab" class="tab-content">
        <div class="section-header" style="margin-bottom: 20px;">
            <h3 style="margin: 0;">Board of Directors</h3>
            <button class="btn-add" onclick="addManagement('board_directors')">+ Add Member</button>
        </div>
        <div class="management-grid">
            <?php foreach ($boardDirectors as $member): ?>
                <div class="management-card">
                    <button class="delete-badge" onclick="deleteManagement('board_directors', <?= $member['id'] ?>, '<?= htmlspecialchars($member['name']) ?>')" title="Delete">×</button>
                    <div class="card-image">
                        <?php if ($member['image_path']): ?>
                            <img src="../<?= htmlspecialchars($member['image_path']) ?>">
                        <?php else: ?>
                            <div class="no-image-placeholder">👤</div>
                        <?php endif; ?>
                    </div>
                    <div class="card-info">
                        <h4><?= htmlspecialchars($member['name']) ?></h4>
                        <p><?= htmlspecialchars($member['position']) ?></p>
                    </div>
                    <button class="btn-edit-card" onclick="editManagement('board_directors', <?= $member['id'] ?>)">✏️ Edit</button>
                </div>
            <?php endforeach; ?>
            
            <?php if (empty($boardDirectors)): ?>
                <div class="empty-state">
                    <p>No members added yet</p>
                    <button class="btn-add" onclick="addManagement('board_directors')">+ Add First Member</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Senior Management Tab -->
    <div id="senior-tab" class="tab-content">
        <div class="section-header" style="margin-bottom: 20px;">
            <h3 style="margin: 0;">Senior Management Team</h3>
            <button class="btn-add" onclick="addManagement('senior_management')">+ Add Member</button>
        </div>
        <div class="management-grid">
            <?php foreach ($seniorManagement as $member): ?>
                <div class="management-card">
                    <button class="delete-badge" onclick="deleteManagement('senior_management', <?= $member['id'] ?>, '<?= htmlspecialchars($member['name']) ?>')" title="Delete">×</button>
                    <div class="card-image">
                        <?php if ($member['image_path']): ?>
                            <img src="../<?= htmlspecialchars($member['image_path']) ?>">
                        <?php else: ?>
                            <div class="no-image-placeholder">👤</div>
                        <?php endif; ?>
                    </div>
                    <div class="card-info">
                        <h4><?= htmlspecialchars($member['name']) ?></h4>
                        <p><?= htmlspecialchars($member['position']) ?></p>
                    </div>
                    <button class="btn-edit-card" onclick="editManagement('senior_management', <?= $member['id'] ?>)">✏️ Edit</button>
                </div>
            <?php endforeach; ?>
            
            <?php if (empty($seniorManagement)): ?>
                <div class="empty-state">
                    <p>No members added yet</p>
                    <button class="btn-add" onclick="addManagement('senior_management')">+ Add First Member</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Add/Edit Modal -->
<div id="managementModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeMgmtModal()">&times;</span>
        <h3 id="mgmtModalTitle">Add Member</h3>
        
        <form id="managementForm" enctype="multipart/form-data">
            <input type="hidden" id="mgmtTable" name="table">
            <input type="hidden" id="mgmtId" name="id">
            <input type="hidden" id="mgmtAction" name="action" value="create">
            
            <div class="form-group">
                <label>Namesss: *</label>
                <input type="text" name="name" id="memberName" required>
            </div>
            
            <div class="form-group">
                <label>Position: *</label>
                <input type="text" name="position" id="memberPosition" required>
            </div>
            
            <div class="form-group">
                <label>Photo:</label>
                <div id="currentImagePreview"></div>
                <input type="file" name="image" accept="image/*" id="imageInput">
                <small>Professional photo (square format recommended, max 5MB)</small>
            </div>
            
            <div class="form-group">
                <label>Display Order:</label>
                <input type="number" name="display_order" id="displayOrder" value="0" min="0">
                <small>Lower numbers appear first</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-save" id="saveBtn">💾 Save</button>
                <button type="button" class="btn-cancel" onclick="closeMgmtModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<style>
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 30px;
    border-bottom: 2px solid #e0e0e0;
}

.tab-btn {
    padding: 12px 24px;
    background: none;
    border: none;
    border-bottom: 3px solid transparent;
    cursor: pointer;
    font-weight: 600;
    color: #666;
    transition: all 0.3s;
}

.tab-btn.active {
    color: #3498db;
    border-bottom-color: #3498db;
}

.tab-btn:hover {
    color: #3498db;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.management-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.management-card {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    transition: all 0.3s;
    position: relative;
}

.management-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.delete-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #e74c3c;
    color: white;
    border: none;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 20px;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s;
    z-index: 10;
}

.management-card:hover .delete-badge {
    opacity: 1;
}

.delete-badge:hover {
    background: #c0392b;
    transform: scale(1.1);
}

.card-image {
    margin-bottom: 15px;
}

.card-image img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e0e0e0;
}

.no-image-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #ecf0f1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    margin: 0 auto;
    color: #95a5a6;
}

.card-info h4 {
    margin: 0 0 5px 0;
    color: #2c3e50;
    font-size: 16px;
}

.card-info p {
    margin: 0 0 15px 0;
    color: #7f8c8d;
    font-size: 13px;
}

.btn-edit-card {
    padding: 8px 16px;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 13px;
    transition: background 0.3s;
}

.btn-edit-card:hover {
    background: #2980b9;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 2px dashed #dee2e6;
}

.empty-state p {
    color: #6c757d;
    font-size: 16px;
    margin-bottom: 20px;
}

#currentImagePreview {
    margin-bottom: 10px;
}

#currentImagePreview img {
    max-width: 150px;
    max-height: 150px;
    border-radius: 8px;
    border: 2px solid #e0e0e0;
}
</style>

<script>
function showTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById(tab + '-tab').classList.add('active');
    event.target.classList.add('active');
}

function addManagement(table) {
    // Reset form for new entry
    document.getElementById('managementForm').reset();
    document.getElementById('mgmtTable').value = table;
    document.getElementById('mgmtId').value = '';
    document.getElementById('mgmtAction').value = 'create';
    document.getElementById('currentImagePreview').innerHTML = '';
    
    // Set modal title based on table
    let title = 'Add New Member';
    if (table === 'top_management') title = 'Add Top Management';
    if (table === 'board_directors') title = 'Add Board Director';
    if (table === 'senior_management') title = 'Add Senior Manager';
    
    document.getElementById('mgmtModalTitle').textContent = title;
    document.getElementById('managementModal').style.display = 'block';
}

function editManagement(table, id) {
    fetch(`handlers/management-handler.php?action=get&table=${table}&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const member = data.data;
                document.getElementById('mgmtTable').value = table;
                document.getElementById('mgmtId').value = member.id;
                document.getElementById('mgmtAction').value = 'update';
                document.getElementById('memberName').value = member.name;
                document.getElementById('memberPosition').value = member.position;
                document.getElementById('displayOrder').value = member.display_order;
                
                // Show current image
                const previewDiv = document.getElementById('currentImagePreview');
                if (member.image_path) {
                    previewDiv.innerHTML = `<img src="../${member.image_path}" alt="Current photo">`;
                } else {
                    previewDiv.innerHTML = '<p style="color: #999; font-size: 13px;">No photo uploaded</p>';
                }
                
                document.getElementById('mgmtModalTitle').textContent = 'Edit ' + member.name;
                document.getElementById('managementModal').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Failed to load member data');
        });
}

function deleteManagement(table, id, name) {
    if (!confirm(`Are you sure you want to delete "${name}"?\n\nThis action cannot be undone.`)) {
        return;
    }
    
    fetch('handlers/management-handler.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=delete&table=${table}&id=${id}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('✅ Member deleted successfully');
            location.reload();
        } else {
            alert('❌ Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to delete member');
    });
}

function closeMgmtModal() {
    document.getElementById('managementModal').style.display = 'none';
}

document.getElementById('managementForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const saveBtn = document.getElementById('saveBtn');
    
    // Disable button during submission
    saveBtn.disabled = true;
    saveBtn.textContent = '⏳ Saving...';
    
    try {
        const response = await fetch('handlers/management-handler.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('✅ Saved successfully!');
            location.reload();
        } else {
            alert('❌ Error: ' + result.error);
            saveBtn.disabled = false;
            saveBtn.textContent = '💾 Save';
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Network error');
        saveBtn.disabled = false;
        saveBtn.textContent = '💾 Save';
    }
});

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('managementModal');
    if (event.target == modal) {
        closeMgmtModal();
    }
}
</script>