<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$stmt = $db->prepare("SELECT * FROM `about_us` WHERE `id` = 1");
$stmt->execute();
$about = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<section class="content-section">
    <h2>ℹ️ About Us Information</h2>
    
    <form id="aboutForm" enctype="multipart/form-data">
            
        <div class="form-group">
            <label>Company Name:</label>
            <textarea name="companyName" rows="1"><?= htmlspecialchars($about['companyName']) ?></textarea>
        </div>
        <div class="form-row">
            <div class="form-col-6">
                <div class="form-group">
                    <label>Company Image:</label>
                    <?php if ($about['image_path']): ?>
                        <img src="../<?= htmlspecialchars($about['image_path']) ?>" class="preview-image">
                    <?php endif; ?>
                    <input type="file" name="image" accept="image/*">
                    <small>Main about us image <br><red style='color:darkred'> #reduce image size if failed to upload</red></small>
                </div>
            </div>
            
            <div class="form-col-6">
                <div class="form-group">
                    <label>Vision & Mission Image:</label>
                    <?php if ($about['vision_mission_image']): ?>
                        <img src="../<?= htmlspecialchars($about['vision_mission_image']) ?>" class="preview-image">
                    <?php endif; ?>
                    <input type="file" name="vision_mission_image" accept="image/*">
                    <small>Vision & mission section image <br><red style='color:darkred'> #reduce image size if failed to upload</red></small>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label>Details 1:</label>
            <textarea name="description" rows="2"><?= htmlspecialchars($about['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Details 2:</label>
            <textarea name="description2" rows="2"><?= htmlspecialchars($about['description2']) ?></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-col-3">
                <div class="form-group">
                    <label>Beds Number:</label>
                    <input type="text" name="beds_count" value="<?= $about['beds_count'] ?>" min="0">
                </div>
            </div>
            
            <div class="form-col-3">
                <div class="form-group">
                    <label>Resident Number:</label>
                    <input type="text" name="resident_count" value="<?= $about['resident_count'] ?>" min="0">
                </div>
            </div>
            
            <div class="form-col-3">
                <div class="form-group">
                    <label>Visiting Number:</label>
                    <input type="text" name="visiting_count" value="<?= $about['visiting_count'] ?>" min="0">
                </div>
            </div>
            
            <div class="form-col-3">
                <div class="form-group">
                    <label>Sessional Number:</label>
                    <input type="text" name="sessional_count" value="<?= $about['sessional_count'] ?>" min="0">
                </div>
            </div>
            <div class="form-col-3">
                <div class="form-group">
                    <label>MO Number:</label>
                    <input type="text" name="mo_number" value="<?= $about['mo_number'] ?>" min="0">
                </div>
            </div>
        </div>

        
        <div class="form-group">
            <label>Vision:</label>
            <textarea name="vision" rows="4"><?= htmlspecialchars($about['vision']) ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Mission:</label>
            <textarea name="mission" rows="4"><?= htmlspecialchars($about['mission']) ?></textarea>
        </div>
        
        <div id="aboutMessage"></div>
        
        <button type="submit" class="btn-save">💾 Save Changes</button>
    </form>
</section>

<style>
.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.form-col-6 {
    grid-column: span 1;
}

.form-col-3 {
    grid-column: span 1;
}

.preview-image {
    max-width: 100%;
    max-height: 200px;
    border-radius: 8px;
    margin-bottom: 10px;
    border: 2px solid #e0e0e0;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.getElementById('aboutForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const messageDiv = document.getElementById('aboutMessage');
    const submitBtn = e.target.querySelector('button[type="submit"]');
    
    submitBtn.disabled = true;
    submitBtn.textContent = '⏳ Saving...';
    
    try {
        const response = await fetch('controllers/about.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            messageDiv.textContent = '✅ About us information updated successfully!';
            messageDiv.className = 'alert-success';
            setTimeout(() => location.reload(), 1500);
        } else {
            messageDiv.textContent = '❌ ' + result.error;
            messageDiv.className = 'alert-error';
        }
        
        messageDiv.style.display = 'block';
    } catch (error) {
        messageDiv.textContent = '❌ Network error';
        messageDiv.className = 'alert-error';
        messageDiv.style.display = 'block';
    }
    
    submitBtn.disabled = false;
    submitBtn.textContent = '💾 Save Changes';
});
</script>