<!-- NAVIGATION BAR -->
<nav class="admin-nav">
    <a href="?page=dashboard" class="nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
        📊 Dashboard
    </a>
    <a href="?page=news" class="nav-link <?= $currentPage === 'news' ? 'active' : '' ?>">
        📰 News
    </a>
    <a href="?page=packages" class="nav-link <?= $currentPage === 'packages' ? 'active' : '' ?>">
        📦 Packages
    </a>
    <a href="?page=settings" class="nav-link <?= $currentPage === 'settings' ? 'active' : '' ?>">
        ⚙️ Settings
    </a>
    <a href="../index.php" class="nav-link" target="_blank">
        🌐 View Portal
    </a>
</nav>