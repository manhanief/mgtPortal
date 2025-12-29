<?php
$slides = getTableData($db, 'elearning_slides', 'display_order', 'ASC');
?>

<section class="content-section">
    <div class="section-header">
        <h2>🎓 E-Learning Slides</h2>
        <button class="btn-add" onclick="openSlideModal()">+ Add Slide</button>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Slide #</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Video URL</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($slides as $slide): ?>
                <tr>
                    <td><?= $slide['display_order'] ?></td>
                    <td><span class="badge" style="background: #3498db; color: white;">#<?= $slide['slide_number'] ?></span></td>
                    <td>
                        <?php if ($slide['image_path']): ?>
                            <img src="../<?= htmlspecialchars($slide['image_path']) ?>" class="table-thumb">
                        <?php else: ?>
                            <span class="no-image-badge">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= htmlspecialchars($slide['title']) ?></strong></td>
                    <td>
                        <?php if ($slide['video_url']): ?>
                            <a href="<?= htmlspecialchars($slide['video_url']) ?>" target="_blank" class="link-preview">🎥 Video</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
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

<!-- Modal -->
<div id="slideModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeSlideModal()">&times;</span>
        <h3 id="slideModalTitle">Add E-Learning Slide</h3>
        
        <form id="slideForm" enctype="multipart/form-data">
            <input type="hidden" id="slideId" name="id">
            
            <div class="form-group">
                <label>Title: *</label>
                <input type="text" name="title" required>
            </div>
            
            <div class="form-group">
                <label>Slide Number:</label>
                <input type="number" name="slide_number" min="1">
            </div>
            
            <div class="form-group">
                <label>Content:</label>
                <textarea name="content" rows="4"></textarea>
            </div>
            
            <div class="form-group">
                <label>Video URL:</label>
                <input type="url" name="video_url" placeholder="https://youtube.com/...">
                <small>YouTube, Vimeo, or direct video link</small>
            </div>
            
            <div class="form-group">
                <label>Image/Thumbnail:</label>
                <input type="file" name="image" accept="image/*">
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
                <button type="button" class="btn-cancel" onclick="closeSlideModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openSlideModal() {
    document.getElementById('slideModal').style.display = 'block';
    document.getElementById('slideModalTitle').textContent = 'Add E-Learning Slide';
    document.getElementById('slideForm').reset();
    document.getElementById('slideId').value = '';
}

function closeSlideModal() {
    document.getElementById('slideModal').style.display = 'none';
}

function editSlide(id) {
    fetch(`controllers/elearning.php?action=get&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const slide = data.data;
                document.getElementById('slideId').value = slide.id;
                document.querySelector('[name="title"]').value = slide.title;
                document.querySelector('[name="slide_number"]').value = slide.slide_number || '';
                document.querySelector('[name="content"]').value = slide.content || '';
                document.querySelector('[name="video_url"]').value = slide.video_url || '';
                document.querySelector('[name="display_order"]').value = slide.display_order;
                document.querySelector('[name="is_active"]').checked = slide.is_active == 1;
                
                document.getElementById('slideModalTitle').textContent = 'Edit Slide';
                document.getElementById('slideModal').style.display = 'block';
            }
        });
}

function deleteSlide(id) {
    if (!confirm('Delete this slide?')) return;
    
    fetch('controllers/elearning.php', {
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

document.getElementById('slideForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    formData.append('action', document.getElementById('slideId').value ? 'update' : 'create');
    
    const response = await fetch('controllers/elearning.php', {
        method: 'POST',
        body: formData
    });
    
    const result = await response.json();
    if (result.success) location.reload();
    else alert(result.error);
});
</script>