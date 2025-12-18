<?php
require_once 'admin/config.php';
$db = getDB();

// Get news and packages

$news = $db->query("SELECT * FROM `news` ORDER BY `id`")->fetchAll(PDO::FETCH_ASSOC);
$packages = $db->query("SELECT * FROM `packages` ORDER BY `id`")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f7fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 0;
            text-align: center;
            margin-bottom: 40px;
            border-radius: 8px;
        }

        header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .admin-link {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 20px;
            background: rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
            border-radius: 20px;
            font-size: 14px;
            transition: background 0.3s;
        }

        .admin-link:hover {
            background: rgba(255,255,255,0.3);
        }

        .section {
            background: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .section h2 {
            font-size: 24px;
            margin-bottom: 25px;
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s;
            background: #fafafa;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-no-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #ecf0f1 0%, #bdc3c7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7f8c8d;
            font-weight: 500;
        }

        .card-content {
        padding: 20px;
    }

    .card-content h3 {
        font-size: 18px;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .card-content p {
        font-size: 14px;
        color: #666;
        margin-bottom: 12px;
        line-height: 1.5;
    }

    .card-date {
        font-size: 12px;
        color: #999;
        font-style: italic;
    }
</style>

</head>
<body>
    <div class="container">
        <header>
            <h1>🏢 Company Portal</h1>
            <p>Welcome to our company information center</p>
            <a href="admin/" class="admin-link">🔐 Admin Panel</a>
        </header>
         <!-- NEWS SECTION -->
    <div class="section">
        <h2>📰 Latest News</h2>
        <div class="grid">
            <?php foreach ($news as $item): ?>
                <div class="card">
                    <?php if ($item['image_path']): ?>
                        <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                    <?php else: ?>
                        <div class="card-no-image">No Image</div>
                    <?php endif; ?>
                    <div class="card-content">
                        <h3><?= htmlspecialchars($item['title']) ?></h3>
                        <p><?= htmlspecialchars($item['details']) ?></p>
                        <div class="card-date">
                            Updated: <?= date('F d, Y', strtotime($item['update_date'])) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- PACKAGES SECTION -->
    <div class="section">
        <h2>📦 Our Packages</h2>
        <div class="grid">
            <?php foreach ($packages as $item): ?>
                <div class="card">
                    <?php if ($item['image_path']): ?>
                        <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                    <?php else: ?>
                        <div class="card-no-image">No Image</div>
                    <?php endif; ?>
                    <div class="card-content">
                        <h3><?= htmlspecialchars($item['title']) ?></h3>
                        <p><?= htmlspecialchars($item['details']) ?></p>
                        <div class="card-date">
                            Updated: <?= date('F d, Y', strtotime($item['update_date'])) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>