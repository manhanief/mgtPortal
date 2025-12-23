<?php
$specialDays = $db->query("SELECT * FROM `special_day_week` ORDER BY `week_number`, `day_number`")->fetchAll(PDO::FETCH_ASSOC);
$holidays = $db->query("SELECT * FROM `public_holidays` ORDER BY `date` DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-section">
    <h2>🎉 Special Days & Public Holidays</h2>
    
    <!-- Tabs -->
    <div class="tabs">
        <button class="tab-btn active" onclick="showSpecialTab('special')">Special Days</button>
        <button class="tab-btn" onclick="showSpecialTab('holidays')">Public Holidays</button>
    </div>
    
    <!-- Special Days Tab -->
    <div id="special-tab" class="tab-content active">
        <div class="section-header">
            <h3>Week Special Days (5 per week)</h3>
            <button class="btn-add" onclick="openSpecialDayModal()">+ Add Special Day</button>
        </div>
        
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Week</th>
                        <th>Day #</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($specialDays as $day): ?>
                    <tr>
                        <td>Week <?= $day['week_number'] ?></td>
                        <td>Day <?= $day['day_number'] ?></td>
                        <td>
                            <?php if ($day['image_path']): ?>
                                <img src="../<?= htmlspecialchars($day['image_path']) ?>" class="table-thumb">
                            <?php else: ?>
                                <span class="no-image-badge">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($day['title']) ?></td>
                        <td><?= truncateText($day['description'], 50) ?></td>
                        <td>
                            <button class="btn-icon btn-edit" onclick="editSpecialDay(<?= $day['id'] ?>)">✏️</button>
                            <button class="btn-icon btn-delete" onclick="deleteSpecialDay(<?= $day['id'] ?>)">🗑️</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Public Holidays Tab -->
    <div id="holidays-tab" class="tab-content">
        <div class="section-header">
            <h3>Public Holidays</h3>
            <button class="btn-add" onclick="openHolidayModal()">+ Add Holiday</button>
        </div>
        
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($holidays as $holiday): ?>
                    <tr>
                        <td><?= date('M d, Y', strtotime($holiday['date'])) ?></td>
                        <td><strong><?= htmlspecialchars($holiday['title']) ?></strong></td>
                        <td><?= truncateText($holiday['description'], 50) ?></td>
                        <td>
                            <span class="badge <?= $holiday['is_active'] ? 'badge-active' : 'badge-inactive' ?>">
                                <?= $holiday['is_active'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn-icon btn-edit" onclick="editHoliday(<?= $holiday['id'] ?>)">✏️</button>
                            <button class="btn-icon btn-delete" onclick="deleteHoliday(<?= $holiday['id'] ?>)">🗑️</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Special Day Modal -->
<div id="specialDayModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeSpecialDayModal()">&times;</span>
        <h3 id="specialDayModalTitle">Add Special Day</h3>
        
        <form id="specialDayForm" enctype="multipart/form-data">
            <input type="hidden" id="specialDayId" name="id">
            
            <div class="form-group">
                <label>Week Number: *</label>
                <input type="number" name="week_number" required min="1">
            </div>
            
            <div class="form-group">
                <label>Day Number (1-5): *</label>
                <input type="number" name="day_number" required min="1" max="5">
            </div>
            
            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="title">
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" accept="image/*">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-save">Save</button>
                <button type="button" class="btn-cancel" onclick="closeSpecialDayModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Holiday Modal -->
<div id="holidayModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeHolidayModal()">&times;</span>
        <h3 id="holidayModalTitle">Add Public Holiday</h3>
        
        <form id="holidayForm">
            <input type="hidden" id="holidayId" name="id">
            
            <div class="form-group">
                <label>Date: *</label>
                <input type="date" name="date" required>
            </div>
            
            <div class="form-group">
                <label>Title: *</label>
                <input type="text" name="title" required>
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" checked> Active
                </label>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-save">Save</button>
                <button type="button" class="btn-cancel" onclick="closeHolidayModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function showSpecialTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById(tab + '-tab').classList.add('active');
    event.target.classList.add('active');
}

// Special Day Functions
function openSpecialDayModal() {
    document.getElementById('specialDayModal').style.display = 'block';
    document.getElementById('specialDayModalTitle').textContent = 'Add Special Day';
    document.getElementById('specialDayForm').reset();
    document.getElementById('specialDayId').value = '';
}

function closeSpecialDayModal() {
    document.getElementById('specialDayModal').style.display = 'none';
}

function editSpecialDay(id) {
    fetch(`handlers/special-days-handler.php?action=get_day&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const day = data.data;
                document.getElementById('specialDayId').value = day.id;
                document.querySelector('#specialDayForm [name="week_number"]').value = day.week_number;
                document.querySelector('#specialDayForm [name="day_number"]').value = day.day_number;
                document.querySelector('#specialDayForm [name="title"]').value = day.title || '';
                document.querySelector('#specialDayForm [name="description"]').value = day.description || '';
                
                document.getElementById('specialDayModalTitle').textContent = 'Edit Special Day';
                document.getElementById('specialDayModal').style.display = 'block';
            }
        });
}

function deleteSpecialDay(id) {
    if (!confirm('Delete this special day?')) return;
    
    fetch('handlers/special-days-handler.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=delete_day&id=${id}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) location.reload();
        else alert(data.error);
    });
}

document.getElementById('specialDayForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    formData.append('action', document.getElementById('specialDayId').value ? 'update_day' : 'create_day');
    
    const response = await fetch('handlers/special-days-handler.php', {
        method: 'POST',
        body: formData
    });
    
    const result = await response.json();
    if (result.success) location.reload();
    else alert(result.error);
});

// Holiday Functions
function openHolidayModal() {
    document.getElementById('holidayModal').style.display = 'block';
    document.getElementById('holidayModalTitle').textContent = 'Add Public Holiday';
    document.getElementById('holidayForm').reset();
    document.getElementById('holidayId').value = '';
}

function closeHolidayModal() {
    document.getElementById('holidayModal').style.display = 'none';
}

function editHoliday(id) {
    fetch(`handlers/special-days-handler.php?action=get_holiday&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const holiday = data.data;
                document.getElementById('holidayId').value = holiday.id;
                document.querySelector('#holidayForm [name="date"]').value = holiday.date;
                document.querySelector('#holidayForm [name="title"]').value = holiday.title;
                document.querySelector('#holidayForm [name="description"]').value = holiday.description || '';
                document.querySelector('#holidayForm [name="is_active"]').checked = holiday.is_active == 1;
                
                document.getElementById('holidayModalTitle').textContent = 'Edit Holiday';
                document.getElementById('holidayModal').style.display = 'block';
            }
        });
}

function deleteHoliday(id) {
    if (!confirm('Delete this holiday?')) return;
    
    fetch('handlers/special-days-handler.php', {
method: 'POST',
headers: {'Content-Type': 'application/x-www-form-urlencoded'},
body: action=delete_holiday&id=${id}
})
.then(res => res.json())
.then(data => {
if (data.success) location.reload();
else alert(data.error);
});
}
document.getElementById('holidayForm').addEventListener('submit', async (e) => {
e.preventDefault();const formData = new FormData(e.target);
formData.append('action', document.getElementById('holidayId').value ? 'update_holiday' : 'create_holiday');

const response = await fetch('handlers/special-days-handler.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams(formData)
});

const result = await response.json();
if (result.success) location.reload();
else alert(result.error);});
</script>