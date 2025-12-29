<?php
$topManagement = getTableData($db, 'top_management', 'display_order', 'ASC');
$boardDirectors = getTableData($db, 'board_directors', 'display_order', 'ASC');
$seniorManagement = getTableData($db, 'senior_management', 'display_order', 'ASC');
?>

<section class="content-section">
    <h2>👔 Management Teams</h2>
    
    <!-- Tabs -->
    <div class="tabs">
        <button class="tab-btn active" onclick="showTab('top')">Top Management (9)</button>
        <button class="tab-btn" onclick="showTab('board')">Board of Directors (10)</button>
        <button class="tab-btn" onclick="showTab('senior')">Senior Management (6)</button>
    </div>
    
    <!-- Top Management Tab -->
    <div id="top-tab" class="tab-content active">
        <div class="management-grid">
            <?php foreach ($topManagement as $member): ?>
                <div class="management-card">
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
        </div>
    </div>
    
    <!-- Board Directors Tab -->
    <div id="board-tab" class="tab-content">
        <div class="management-grid">
            <?php foreach ($boardDirectors as $member): ?>
                <div class="management-card">
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
        </div>
    </div>
    
    <!-- Senior Management Tab -->
    <div id="senior-tab" class="tab-content">
        <div class="management-grid">
            <?php foreach ($seniorManagement as $member): ?>
                <div class="management-card">
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
        </div>
    </div>
</section>

<!-- Edit Modal -->
<div id="managementModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeMgmtModal()">&times;</span>
        <h3 id="mgmtModalTitle">Edit Member</h3>
        
        <form id="managementForm" enctype="multipart/form-data">
            <input type="hidden" id="mgmtTable" name="table">
            <input type="hidden" id="mgmtId" name="id">
            
            <div class="form-group">
                <label>Name: *</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Position: *</label>
                <input type="text" name="position" required>
            </div>
            
            <div class="form-group">
                <label>Photo:</label>
                <input type="file" name="image" accept="image/*">
                <small>Professional photo (square format recommended)</small>
            </div>
            
            <div class="form-group">
                <label>Display Order:</label>
                <input type="number" name="display_order" value="0" min="0">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-save">Save</button>
                <button type="button" class="btn-cancel" onclick="closeMgmtModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<style>
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
}

.management-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
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
</style>

<script>
function showTab(tab) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    
    // Show selected tab
    document.getElementById(tab + '-tab').classList.add('active');
    event.target.classList.add('active');
}

function editManagement(table, id) {
    fetch(`controllers/management.php?action=get&table=${table}&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const member = data.data;
                document.getElementById('mgmtTable').value = table;
                document.getElementById('mgmtId').value = member.id;
                document.querySelector('[name="name"]').value = member.name;
                document.querySelector('[name="position"]').value = member.position;
                document.querySelector('[name="display_order"]').value = member.display_order;
                
                document.getElementById('mgmtModalTitle').textContent = 'Edit ' + member.name;
                document.getElementById('managementModal').style.display = 'block';
            }
        });
}

function closeMgmtModal() {
    document.getElementById('managementModal').style.display = 'none';
}

document.getElementById('managementForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    
    const response = await fetch('controllers/management.php', {
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