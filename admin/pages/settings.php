<!-- SETTINGS PAGE -->
<section class="content-section">
    <h2>⚙️ System Settings</h2>
    
    <!-- Change Password Form -->
    <div class="settings-group">
        <h3>🔐 Change Admin Password</h3>
        <p style="color: #666; margin-bottom: 15px;">Update your admin password for security.</p>
        
        <form id="changePasswordForm" style="max-width: 500px;">
            <div class="form-group">
                <label for="current_password">Current Password: *</label>
                <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
            </div>

            <div class="form-group">
                <label for="new_password">New Password: *</label>
                <input type="password" id="new_password" name="new_password" required minlength="6" autocomplete="new-password">
                <small>Minimum 6 characters</small>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm New Password: *</label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="6" autocomplete="new-password">
            </div>

            <div id="passwordMessage"></div>

            <button type="submit" class="btn-save">
                <span id="btnText">💾 Update Password</span>
                <span id="btnLoader" style="display: none;">⏳ Updating...</span>
            </button>
        </form>
    </div>

    <div class="settings-group">
        <h3>👤 Admin Account</h3>
        <p><strong>Username:</strong> admin</p>
        <p><strong>Password:</strong> ••••••••</p>
        <p style="color: #999; font-size: 13px;">Use the form above to change your password</p>
    </div>

    <div class="settings-group">
        <h3>📁 Upload Settings</h3>
        <p><strong>Max File Size:</strong> 5 MB</p>
        <p><strong>Allowed Types:</strong> JPG, PNG, GIF, WebP</p>
        <p><strong>Upload Directory:</strong> /uploads/</p>
    </div>

    <div class="settings-group">
        <h3>💾 Database Info</h3>
        <p><strong>Database:</strong> <?= DB_NAME ?></p>
        <p><strong>Host:</strong> <?= DB_HOST ?></p>
        <p><strong>Tables:</strong> news, packages</p>
        <p><strong>Status:</strong> <span style="color: #27ae60; font-weight: bold;">✓ Connected</span></p>
    </div>

    <div class="settings-group">
        <h3>🖥️ System Information</h3>
        <p><strong>PHP Version:</strong> <?= phpversion() ?></p>
        <p><strong>Server:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></p>
        <p><strong>Admin Path:</strong> <?= __DIR__ ?></p>
    </div>
</section>