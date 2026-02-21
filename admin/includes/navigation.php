<!-- NAVIGATION BAR -->
<nav class="admin-nav">
    <a href="?page=dashboard" class="nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
        Dashboard
    </a>
    
    <!-- Home Section Dropdown -->
    <div class="nav-dropdown">
        <a href="#" class="nav-link <?= in_array($currentPage, ['slideshow', 'systems']) ? 'active' : '' ?>">
            Home <span class="dropdown-arrow">▼</span>
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
            <a href="?page=about">About Info</a>
            <a href="?page=management">Management</a>
            <a href="?page=it_team">IT Team</a>
            <a href="?page=it_roster">IT Roster</a>
            <a href="?page=it_special_days">IT Special Days</a>
        </div>
    </div>
    
    
    <!-- E-Learning Dropdown -->
    <div class="nav-dropdown">
        <a href="#" class="nav-link <?= in_array($currentPage, ['slides', 'learning-tickets']) ? 'active' : '' ?>">
            E-Learning <span class="dropdown-arrow">▼</span>
        </a>
        <div class="dropdown-content">
            <a href="?page=slides">Slides</a>
            <a href="?page=tickets">Tickets</a>
        </div>
    </div>

    <div class="nav-dropdown">
        <a href="#" class="nav-link <?= in_array($currentPage, ['page=news', 'page=packages']) ? 'active' : '' ?>">
             Updates <span class="dropdown-arrow">▼</span>
        </a>
        <div class="dropdown-content">
            <a href="?page=news">News</a>
            <a href="?page=packages">Packages</a>
        </div>
    </div>

    
    <a href="?page=sustainability" class="nav-link <?= $currentPage === 'sustainability' ? 'active' : '' ?>">
         Sustainability
    </a>
    <a href="?page=staff" class="nav-link <?= $currentPage === 'staff' ? 'active' : '' ?>">
        New Staff
    </a>
    
    <a href="?page=extensions" class="nav-link <?= $currentPage === 'extensions' ? 'active' : '' ?>">
         Extensions
    </a>

    
    <div class="nav-dropdown">
        <a href="#" class="nav-link <?= in_array($currentPage, ['settings', '10.26.2.75']) ? 'active' : '' ?>">
            Othes <span class="dropdown-arrow">▼</span>
        </a>
        <div class="dropdown-content">
            <a href="?page=settings">⚙️ Settings</a>
            <a href="10.26.2.75">🌐 IT Portal</a>
        </div>
    </div>
    
</nav>