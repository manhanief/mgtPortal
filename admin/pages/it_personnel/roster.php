<?php
$roster = getTableData($db, 'it_roster', 'id', 'ASC');

//fetch it team list
try{
    $itTeam = getITTeamList($db);
} catch(Exception $e){
    echo '<div class="alert alert-error">Error loading roster data.</div>';
    $itTeam = [];
}
?>

<section class="content-section">
    <h2>📅 IT Roster <?= date('F Y') ?> </h2>
    <p style="color:#ff0000">#please select IT Team for none schedule roster</p>
    <br>
    <div class="roster-grid">
        <?php 
        $currentMonth = date('Y-m');
        $currentYear = date('Y');
        $daysInMonth = date('t'); // Get total days in current month
        
        foreach ($roster as $box): 
            $boxNum = $box['id'];
            
            // Cycle through IT team members
            $staffIndex = ($boxNum - 1) % count($itTeam);
            $staffName = count($itTeam) > 0 ? $itTeam[$staffIndex]['name'] : 'Staff ' . $boxNum;
            
            // Generate date based on box number (cycle through days of month)
            $dayNum = (($boxNum - 1) % $daysInMonth) + 1;
            $autoDate = $currentYear . '-' . date('m') . '-' . str_pad($dayNum, 2, '0', STR_PAD_LEFT);
            
            // Use existing data if available, otherwise use auto-generated
            $displayTitle = !empty($box['title']) ? $box['title'] : $staffName;
            $displayDate = !empty($box['date']) ? $box['date'] : $autoDate;
            $displayColor = !empty($box['color']) ? $box['color'] : '#3498db';
        ?>
            <div class="roster-box" onclick="editRosterBox(<?= $box['id'] ?>)">
                <div class="roster-color-bar" style="background-color: <?= htmlspecialchars($displayColor) ?>"></div>
                <div class="roster-content-area">
                    <div class="roster-number">#<?= $box['id'] ?></div>
                    <div class="roster-title"><?= htmlspecialchars($displayTitle) ?></div>
                    <div class="roster-date"><?= date('M d, Y', strtotime($displayDate)) ?></div>
                </div>
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
                <label>Title (Staff Name):</label>
                <select name="title" id="staffSelect">
                    <option value="">-- Select Staff --</option>
                    <?php foreach($itTeam as $staff): ?>
                        <option value="<?= htmlspecialchars($staff['name']) ?>">
                            <?= htmlspecialchars($staff['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Date:</label>
                <input type="date" name="date">
            </div>
            
            <div class="form-group">
                <label>Color:</label>
                <select name="color" id="colorSelect">
                    <option value="#3498db" style="background-color: #3498db; color: white;">🔵 Blue</option>
                    <option value="#e74c3c" style="background-color: #e74c3c; color: white;">🔴 Red</option>
                    <option value="#2ecc71" style="background-color: #2ecc71; color: white;">🟢 Green</option>
                    <option value="#f39c12" style="background-color: #f39c12; color: white;">🟠 Orange</option>
                    <option value="#9b59b6" style="background-color: #9b59b6; color: white;">🟣 Purple</option>
                    <option value="#1abc9c" style="background-color: #1abc9c; color: white;">🟢 Teal</option>
                    <option value="#e91e63" style="background-color: #e91e63; color: white;">🌸 Pink</option>
                    <option value="#34495e" style="background-color: #34495e; color: white;">⚫ Dark Gray</option>
                    <option value="#16a085" style="background-color: #16a085; color: white;">💚 Dark Teal</option>
                    <option value="#d35400" style="background-color: #d35400; color: white;">🟤 Dark Orange</option>
                </select>
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
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s;
    min-height: 120px;
    position: relative;
}

.roster-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.roster-color-bar {
    height: 8px;
    width: 100%;
}

.roster-content-area {
    padding: 15px;
}

.roster-number {
    position: absolute;
    top: 18px;
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
    padding-right: 40px;
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

.form-group select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

#colorSelect option {
    padding: 8px;
    font-weight: 600;
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
                document.getElementById('staffSelect').value = box.title || '';
                document.querySelector('[name="date"]').value = box.date || '';
                document.getElementById('colorSelect').value = box.color || '#3498db';
                
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
    
    const response = await fetch('controllers/roster.php?action=update', {
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