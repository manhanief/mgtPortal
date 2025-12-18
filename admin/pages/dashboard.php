<!-- QUICK STATS -->
<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon">📰</div>
        <div class="stat-content">
            <h3>News Items</h3>
            <p class="stat-number">4</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-content">
            <h3>Packages</h3>
            <p class="stat-number">4</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📸</div>
        <div class="stat-content">
            <h3>Total Images</h3>
            <p class="stat-number">
                <?php 
                $imageCount = 0;
                foreach ($news as $item) if ($item['image_path']) $imageCount++;
                foreach ($packages as $item) if ($item['image_path']) $imageCount++;
                echo $imageCount;
                ?>
            </p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🕒</div>
        <div class="stat-content">
            <h3>Last Update</h3>
            <p class="stat-number" style="font-size: 14px;">
                <?php
                $allItems = array_merge($news, $packages);
                usort($allItems, function($a, $b) {
                    return strtotime($b['update_date']) - strtotime($a['update_date']);
                });
                echo date('M d, Y', strtotime($allItems[0]['update_date']));
                ?>
            </p>
        </div>
    </div>
</div>

<!-- NEWS SECTION -->
<section class="content-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">📰 Manage News (4 Items)</h2>
        <a href="?page=news" class="btn-view-all">View All →</a>
    </div>
    <div class="items-grid">
        <?php foreach ($news as $item): ?>
            <div class="item-card">
                <?php if ($item['image_path']): ?>
                    <img src="../<?= htmlspecialchars($item['image_path']) ?>" alt="News <?= $item['id'] ?>">
                <?php else: ?>
                    <div class="no-image">No Image</div>
                <?php endif; ?>
                <h3><?= htmlspecialchars($item['title']) ?></h3>
                <p><?= htmlspecialchars(substr($item['details'], 0, 100)) ?>...</p>
                <small>Updated: <?= date('M d, Y', strtotime($item['update_date'])) ?></small>
                <a href="edit-item.php?type=news&id=<?= $item['id'] ?>" class="btn-edit">Edit</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- PACKAGES SECTION -->
<section class="content-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">📦 Manage Packages (4 Items)</h2>
        <a href="?page=packages" class="btn-view-all">View All →</a>
    </div>
    <div class="items-grid">
        <?php foreach ($packages as $item): ?>
            <div class="item-card">
                <?php if ($item['image_path']): ?>
                    <img src="../<?= htmlspecialchars($item['image_path']) ?>" alt="Package <?= $item['id'] ?>">
                <?php else: ?>
                    <div class="no-image">No Image</div>
                <?php endif; ?>
                <h3><?= htmlspecialchars($item['title']) ?></h3>
                <p><?= htmlspecialchars(substr($item['details'], 0, 100)) ?>...</p>
                <small>Updated: <?= date('M d, Y', strtotime($item['update_date'])) ?></small>
                <a href="edit-item.php?type=packages&id=<?= $item['id'] ?>" class="btn-edit">Edit</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>