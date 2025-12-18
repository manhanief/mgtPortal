<!-- PACKAGES ONLY PAGE -->
<section class="content-section">
    <h2>📦 Manage Packages (4 Items)</h2>
    <div class="items-grid">
        <?php foreach ($packages as $item): ?>
            <div class="item-card">
                <?php if ($item['image_path']): ?>
                    <img src="../<?= htmlspecialchars($item['image_path']) ?>" alt="Package <?= $item['id'] ?>">
                <?php else: ?>
                    <div class="no-image">No Image</div>
                <?php endif; ?>
                <h3><?= htmlspecialchars($item['title']) ?></h3>
                <p><?= htmlspecialchars($item['details']) ?></p>
                <small>Updated: <?= date('M d, Y', strtotime($item['update_date'])) ?></small>
                <a href="edit-item.php?type=packages&id=<?= $item['id'] ?>" class="btn-edit">Edit</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>