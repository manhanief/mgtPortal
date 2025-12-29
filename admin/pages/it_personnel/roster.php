<?php
$roster = getTableData($db, 'it_roster', 'id', 'ASC');
?>

<section class="content-section">
    <h2>📅 IT Roster (35 Boxes)</h2>
    
    <div class="roster-grid">
        <?php foreach ($roster as $box): ?>
            <div class="roster-box" onclick="editRosterBox(<?= $box['id'] ?>)" style="border-left: 4px solid <?= htmlspecialchars($box['color']) ?>">
                <div class="roster-number">#<?= $box['id'] ?></div>
                <?php if ($box['title']): ?>
                    <div class="roster-title"><?= htmlspecialchars($box['title']) ?></div>
                <?php endif; ?>
                <?php if ($box['date']): ?>
                    <div class="roster-date"><?= date('M d, Y', strtotime($box['date'])) ?></div>
                <?php endif; ?>
                <?php if ($box['content']): ?>
                    <div class="roster-content"><?= truncateText($box['content'], 50) ?></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Edit Modal -->
<div id="rosterModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeRosterModal()">&times;</span>
        <h3 id="rosterModalTitle">Edit Roster Box</h3>
        
        <form id="rosterForm">
            <input type="hidden" id="rosterId" name="id">
            
            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="title">
            </div>
            
            <div class="form-group">
                <label>Content:</label>
                <textarea name="content" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>Date:</label>
                <input type="date" name="date">
            </div>
            
            <div class="form-group">
                <label>Color:</label>
                <input type="color" name="color" value="#3498db">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-save">Save</button>
                <button type="button" class="btn-cancel" onclick="closeRosterModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<style>
.roster-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 15px;
}

.roster-box {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    cursor: pointer;
    transition: all 0.3s;
    min-height: 120px;
    position: relative;
}

.roster-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.roster-number {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #ecf0f1;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: bold;
    color: #7f8c8d;
}

.roster-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    font-size: 14px;
}

.roster-date {
    font-size: 12px;
    color: #7f8c8d;
    margin-bottom: 8px;
}

.roster-content {
    font-size: 13px;
    color: #666;
    line-height: 1.4;
}
</style>

<script>
function editRosterBox(id) {
    fetch(`controllers/roster.php?action=get&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const box = data.data;
                document.getElementById('rosterId').value = box.id;
                document.querySelector('[name="title"]').value = box.title || '';
                document.querySelector('[name="content"]').value = box.content || '';
                document.querySelector('[name="date"]').value = box.date || '';
                document.querySelector('[name="color"]').value = box.color || '#3498db';
                
                document.getElementById('rosterModalTitle').textContent = 'Edit Roster Box #' + box.id;
                document.getElementById('rosterModal').style.display = 'block';
            }
        });
}

function closeRosterModal() {
    document.getElementById('rosterModal').style.display = 'none';
}

document.getElementById('rosterForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    
    const response = await fetch('controllers/roster.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(formData)
    });
    
    const result = await response.json();
    
    if (result.success) {
        location.reload();
    } else {
        alert(result.error);
    }
});
</script>