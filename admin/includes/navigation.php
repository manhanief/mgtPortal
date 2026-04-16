<?php
    $conn = new mysqli('localhost', 'root', '', 'company_portal');
    if ($conn->connect_error) {
        die('Database connection failed: ' . $conn->connect_error);
    }
    $result = $conn->query("SELECT * FROM navigation_menu ORDER BY id ASC");
    $navigationItems = [];
    while ($row = $result->fetch_assoc()) {
        $navigationItems[] = $row;
    }
    $conn->close();
?>
<!-- NAVIGATION BAR -->
<nav class="admin-nav">
    <a href="?page=dashboard" class="nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
        <?= $navigationItems[0]['display_name'] ?? '' ?>
    </a>
    
    <!-- Home Section Dropdown -->
    <div class="nav-dropdown">
        <a href="#" class="nav-link <?= in_array($currentPage, ['slideshow', 'systems']) ? 'active' : '' ?>">
            <?= $navigationItems[4]['display_name'] ?? 'Home' ?> <span class="dropdown-arrow">▼</span>
        </a>
        <div class="dropdown-content">
            <a href="?page=slideshow">Slideshow</a>
            <a href="?page=systems">Systems List</a>
        </div>
    </div>
    
    <!-- About Us Dropdown -->
    <div class="nav-dropdown">
        <a href="#" class="nav-link <?= in_array($currentPage, ['about-info', 'management']) ? 'active' : '' ?>">
            Corporate Profile <span class="dropdown-arrow">▼</span>
        </a>
        <div class="dropdown-content">
            <a href="?page=about"><?= $navigationItems[1]['display_name'] ?? '' ?></a>
            <a href="?page=management"><?= $navigationItems[2]['display_name'] ?? '' ?></a>
            <a href="?page=it_team"><?= $navigationItems[3]['display_name'] ?? '' ?></a>
            <a href="?page=it_roster"><?= $navigationItems[3]['display_name'] ?? '' ?> Roster</a>
            <a href="?page=it_special_days"><?= $navigationItems[3]['display_name'] ?? '' ?> Special Days</a>
        </div>
    </div>
    
    
    <!-- E-Learning Dropdown -->
    <div class="nav-dropdown">
        <a href="#" class="nav-link <?= in_array($currentPage, ['slides', 'learning-tickets']) ? 'active' : '' ?>">
            <?= $navigationItems[6]['display_name'] ?? '' ?> <span class="dropdown-arrow">▼</span>
        </a>
        <div class="dropdown-content">
            <a href="?page=slides">Slides</a>
            <a href="?page=tickets">Tickets</a>
        </div>
    </div>

    <div class="nav-dropdown">
        <a href="#" class="nav-link <?= in_array($currentPage, ['page=news', 'page=packages']) ? 'active' : '' ?>">
             <?= $navigationItems[8]['display_name'] ?? '' ?> <span class="dropdown-arrow">▼</span>
        </a>
        <div class="dropdown-content">
            <a href="?page=news">News</a>
            <a href="?page=packages">Packages</a>
        </div>
    </div>

    
    <a href="?page=sustainability" class="nav-link <?= $currentPage === 'sustainability' ? 'active' : '' ?>">
            <?= $navigationItems[7]['display_name'] ?? '' ?>
    </a>
    <a href="?page=staff" class="nav-link <?= $currentPage === 'staff' ? 'active' : '' ?>">
        <?= $navigationItems[5]['display_name'] ?? '' ?>
    </a>
    
    <a href="?page=extensions" class="nav-link <?= $currentPage === 'extensions' ? 'active' : '' ?>">
         <?= $navigationItems[10]['display_name'] ?? '' ?>
    </a>

    
    <div class="nav-dropdown">
        <a href="#" class="nav-link <?= in_array($currentPage, ['settings', '10.26.2.75']) ? 'active' : '' ?>">
            Others <span class="dropdown-arrow">▼</span>
        </a>
        <div class="dropdown-content">
            <a href="?page=navigation">Navigation</a>
            <a href="?page=kpj"><?= $navigationItems[9]['display_name'] ?? '' ?></a>
            <a href="?page=settings">Settings</a>
            <a href="10.26.2.75">IT Portal</a>
        </div>
    </div>
    
</nav>