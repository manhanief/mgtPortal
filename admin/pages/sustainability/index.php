<?php
$sustainability = getTableData($db, 'sustainability', 'display_order', 'ASC');
?>

<section class="content-section">
    <div class="section-header">
        <h2>🌱 Sustainability Items</h2>
        <button class="btn-add" onclick="openSustainModal()">+ Add Item</button>
    </div>

    <div class="sustainability-grid">
        <?php foreach ($sustainability as $item): ?>
            <div class="sustain-card">
                <?php if ($item['image_path']): ?>
                    <img src="../<?= htmlspecialchars($item['image_path']) ?>" class="sustain-image">
                <?php else: ?>
                    <div class="no-image-placeholder">🌱</div>
                <?php endif; ?>
                <h3><?= htmlspecialchars($item['title']) ?></h3>
                <?php if ($item['number_value']): ?>
                    <div class="sustain-number"><?= number_format($item['number_value']) ?></div>
                <?php endif; ?>
                <?php if ($item['description']): ?>
                    <p><?= truncateText($item['description'], 100) ?></p>
                <?php endif; ?>
                <div class="card-actions">
                    <button class="btn-edit-card" onclick="editSustain(<?= $item['id'] ?>)">✏️ Edit</button>
                    <button class="btn-icon btn-delete" onclick="deleteSustain(<?= $item['id'] ?>)">🗑️</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Modal -->
<div id="sustainModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeSustainModal()">&times;</span>
        <h3 id="sustainModalTitle">Add Sustainability Item</h3>
        
        <form id="sustainForm" enctype="multipart/form-data">
            <input type="hidden" id="sustainId" name="id">
            
            <div class="form-group">
                <label>Title: *</label>
                <input type="text" name="title" required>
            </div>
            
            <div class="form-group">
                <label>Number Value:</label>
                <input type="number" name="number_value" min="0">
                <small>E.g., CO2 reduced, trees planted, etc.</small>
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" accept="image/*">
            </div>
            
            <div class="form-group">
                <label>Display Order:</label>
                <input type="number" name="display_order" value="0" min="0">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-save">Save</button>
                <button type="button" class="btn-cancel" onclick="closeSustainModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<style>
.sustainability-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.sustain-card {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s;
}

.sustain-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.sustain-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 15px;
}

.sustain-card h3 {
    color: #27ae60;
    margin-bottom: 10px;
}

.sustain-number {
    font-size: 36px;
    font-weight: bold;
    color: #27ae60;
    margin: 15px 0;
}

.sustain-card p {
    color: #666;
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 15px;
}

.card-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
}
</style>

<script>
function openSustainModal() {
    document.getElementById('sustainModal').style.display = 'block';
    document.getElementById('sustainModalTitle').textContent = 'Add Sustainability Item';
    document.getElementById('sustainForm').reset();
    document.getElementById('sustainId').value = '';
}

function closeSustainModal() {
    document.getElementById('sustainModal').style.display = 'none';
}

function editSustain(id) {
    fetch(`handlers/sustainability-handler.php?action=get&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const item = data.data;
                document.getElementById('sustainId').value = item.id;
                document.querySelector('[name="title"]').value = item.title;
                document.querySelector('[name="number_value"]').value = item.number_value || '';
                document.querySelector('[name="description"]').value = item.description || '';
                document.querySelector('[name="display_order"]').value = item.display_order;
                
                document.getElementById('sustainModalTitle').textContent = 'Edit Item';
                document.getElementById('sustainModal').style.display = 'block';
            }
        });
}

function deleteSustain(id) {
    if (!confirm('Delete this item?')) return;
    
    fetch('handlers/sustainability-handler.php', {
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

document.getElementById('sustainForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    formData.append('action', document.getElementById('sustainId').value ? 'update' : 'create');
    
    const response = await fetch('handlers/sustainability-handler.php', {
        method: 'POST',
        body: formData
    });
    
    const result = await response.json();
    if (result.success) location.reload();
    else alert(result.error);
});
</script>