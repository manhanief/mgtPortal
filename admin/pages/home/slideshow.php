<?php
$slideshow = getTableData($db, 'slideshow', 'display_order', 'ASC');
?>

<section class="content-section">
    <div class="section-header">
        <h2>📸 Manage Slideshow</h2>
        <button class="btn-add" onclick="openAddModal()">+ Add New Slide</button>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Details</th>
                    <th>Link URL</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($slideshow as $slide): ?>
                <tr>
                    <td><?= $slide['display_order'] ?></td>
                    <td>
                        <?php if ($slide['image_path']): ?>
                            <img src="../<?= htmlspecialchars($slide['image_path']) ?>" class="table-thumb">
                        <?php else: ?>
                            <span class="no-image-badge">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($slide['title']) ?></td>
                    <td><?= truncateText($slide['details'], 50) ?></td>
                    <td><a href="<?= htmlspecialchars($slide['link_url']) ?>" target="_blank" class="link-preview"><?= truncateText($slide['link_url'], 30) ?></a></td>
                    <td>
                        <span class="badge <?= $slide['is_active'] ? 'badge-active' : 'badge-inactive' ?>">
                            <?= $slide['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td>
                        <button class="btn-icon btn-edit" onclick="editSlide(<?= $slide['id'] ?>)" title="Edit">✏️</button>
                        <button class="btn-icon btn-delete" onclick="deleteSlide(<?= $slide['id'] ?>)" title="Delete">🗑️</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Add/Edit Modal -->
<div id="slideModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3 id="modalTitle">Add New Slide</h3>
        
        <form id="slideForm" enctype="multipart/form-data">
            <input type="hidden" id="slideId" name="id">
            
            <div class="form-group">
                <label>Title: *</label>
                <input type="text" name="title" required>
            </div>
            
            <div class="form-group">
                <label>Details:</label>
                <textarea name="details" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>Link URL:</label>
                <input type="url" name="link_url" placeholder="https://example.com">
            </div>
            
            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" accept="image/*">
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
                <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
// Modal functions
function openAddModal() {
    document.getElementById('slideModal').style.display = 'block';
    document.getElementById('modalTitle').textContent = 'Add New Slide';
    document.getElementById('slideForm').reset();
    document.getElementById('slideId').value = '';
}

function closeModal() {
    document.getElementById('slideModal').style.display = 'none';
}

function editSlide(id) {
    // Fetch slide data and populate form
    fetch(`controllers/slideshow.php?action=get&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const slide = data.data;
                document.getElementById('slideId').value = slide.id;
                document.querySelector('[name="title"]').value = slide.title;
                document.querySelector('[name="details"]').value = slide.details || '';
                document.querySelector('[name="link_url"]').value = slide.link_url || '';
                document.querySelector('[name="display_order"]').value = slide.display_order;
                document.querySelector('[name="is_active"]').checked = slide.is_active == 1;
                
                document.getElementById('modalTitle').textContent = 'Edit Slide';
                document.getElementById('slideModal').style.display = 'block';
            }
        });
}

function deleteSlide(id) {
    if (!confirm('Delete this slide?')) return;
    
    fetch('controllers/slideshow.php', {
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

// Form submission
document.getElementById('slideForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    formData.append('action', document.getElementById('slideId').value ? 'update' : 'create');
    
    const response = await fetch('controllers/slideshow.php', {
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

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('slideModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>