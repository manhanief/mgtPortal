# MPortal - Enterprise Information & Management Portal

## Overview

**MPortal** is a comprehensive **enterprise information and management portal** designed for healthcare organizations and businesses. It provides a centralized platform for disseminating company information, managing organizational structure, maintaining employee directories, and facilitating internal communications.

Built with **PHP 7+** and **MySQL**, MPortal features a dual-interface architecture:
- **Admin Panel** - Content management and system administration
- **Public Portal** - Employee and stakeholder information access

---

## ✨ Key Features

### Content Management
- **News & Updates** - Publish company announcements with images and timestamps
- **Organizational Hierarchy** - Manage top management, board of directors, and senior management structures
- **Personnel Directory** - Complete IT/staff profiles with photos, contacts, and extensions
- **IT Systems Registry** - Directory of organizational systems with descriptions and links
- **E-Learning Platform** - Manage training materials and learning tickets

### Organization Tools
- **Phone Directory** - Department extensions and contact information
- **Holiday Calendar** - Track special days and public holidays
- **Staff Roster** - Scheduling and availability management
- **Sustainability Tracking** - Monitor environmental initiatives and metrics
- **Dynamic Navigation** - Customizable menu system

### User Features
- **Feedback & Ratings** - 1-5 star rating system with comments
- **Countdown Timers** - Event countdowns and announcements
- **Service Packages** - Display organizational offerings and services
- **Responsive Design** - Mobile-friendly interface for all devices

---

## 🏗️ Project Structure

```
MPortal/
├── index.php                    # Main entry point
├── admin/                       # Admin panel
│   ├── index.php               # Admin dashboard router
│   ├── auth.php                # Authentication system
│   ├── config.php              # Configuration & credentials
│   ├── controllers/            # CRUD operations for each module
│   │   ├── about.php
│   │   ├── management.php
│   │   ├── systems.php
│   │   ├── it_team.php
│   │   ├── extension.php
│   │   ├── tickets.php
│   │   ├── special_days.php
│   │   ├── slideshow.php
│   │   └── [other controllers]
│   ├── includes/
│   │   ├── functions.php       # Core utility functions
│   │   ├── header.php          # Admin header template
│   │   ├── footer.php          # Admin footer template
│   │   └── navigation.php      # Admin navigation
│   ├── pages/                  # Admin management pages
│   ├── assets/                 # Admin CSS/JS
│   └── uploads/                # Temporary upload storage
├── itportal/                    # Public portal
│   ├── index.php               # Public homepage
│   ├── config/
│   │   ├── config.php          # App constants
│   │   └── database.php        # Database connection
│   ├── css/                    # Stylesheets (Bootstrap, custom)
│   ├── js/                     # JavaScript files
│   ├── img/                    # Images and media
│   ├── src/                    # Classes and business logic
│   │   ├── Controllers/
│   │   ├── Core/
│   │   ├── Middleware/
│   │   ├── Models/
│   │   └── Services/
│   └── [public pages]          # about.php, blog.php, news.php, etc.
├── uploads/                     # Persistent file storage
│   ├── news/
│   ├── slideshow/
│   ├── systems/
│   ├── it-team/
│   ├── management/
│   ├── kpj/
│   └── [other categories]
└── README.md                    # This file
```

---

## 🚀 Installation & Setup

### Requirements
- **PHP 7.0+**
- **MySQL 5.7+**
- **Apache** (with mod_rewrite)
- **Laragon** (recommended for Windows development)

### Steps

1. **Clone or Download Project**
   ```bash
   # Using git
   git clone <repository-url> MPortal
   cd MPortal
   ```

2. **Database Setup**
   - Import the database schema (if available) into MySQL
   - Default database name: `company_portal`
   ```bash
   mysql -u root -p company_portal < database.sql
   ```

3. **Configure Database Connection**
   
   Edit [admin/config.php](admin/config.php):
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', 'password');
   define('DB_NAME', 'company_portal');
   ```

   Edit [itportal/config/database.php](itportal/config/database.php):
   ```php
   private $host = 'localhost';
   private $db_name = 'company_portal';
   private $user = 'root';
   private $password = 'password';
   ```

4. **Set Directory Permissions**
   ```bash
   chmod 755 uploads/
   chmod 755 admin/uploads/
   ```

5. **Access the Application**
   - **Admin Panel**: `http://localhost/MPortal/admin/`
   - **Public Portal**: `http://localhost/MPortal/` or `http://localhost/MPortal/itportal/`

---

## 🔐 Admin Login

**Default Credentials** (in [admin/auth.php](admin/auth.php)):
- **Username/Password**: `manhanief`

⚠️ **IMPORTANT**: Change these credentials immediately after first login!

---

## 💻 Technology Stack

### Backend
- **PHP 7+** - Server-side scripting language
- **MySQL** - Relational database management
- **PDO (PHP Data Objects)** - Secure database abstraction layer with prepared statements

### Frontend
- **HTML5 & CSS3** - Markup and styling
- **Bootstrap 4/5** - Responsive UI framework
- **jQuery** - JavaScript library for DOM manipulation
- **Font Awesome 5** - Icon library
- **Owl Carousel** - Image slider component
- **Animate.css** - CSS animations
- **AOS (Animate on Scroll)** - Scroll animation library

### Development Environment
- **Laragon** - PHP/MySQL development stack (Windows)
- **Apache** - Web server
- **Git** - Version control (recommended)

---

## 📋 Database Schema Overview

### Core Tables

| Table | Purpose | Fields |
|-------|---------|--------|
| `news` | Company announcements | id, title, description, image, created_at |
| `about_us` | Company information | id, title, content, image, description |
| `systems` | IT systems directory | id, name, description, icon, link |
| `extensions` | Phone directory | id, department, extension, room_no, clinic_no |
| `it_team` | Staff profiles | id, name, position, email, photo, contact |
| `learning_tickets` | E-learning materials | id, title, description, date, file_path |
| `top_management` | Management hierarchy | id, name, position, photo, bio |
| `board_directors` | Board members | id, name, title, photo, bio |
| `senior_management` | Senior staff | id, name, position, photo |
| `special_day_week` | Weekly special days | id, day, description, date |
| `public_holidays` | Holiday calendar | id, date, description, day |
| `sustainability` | Environmental metrics | id, metric_name, value, date |
| `navigation_menu` | Dynamic navigation | id, menu_name, url, order, active |
| `rating` | User feedback | id, page, rating, comment, date |
| `packages` | Services/offerings | id, name, description, image |

---

## 🔧 Core Functions

### [admin/includes/functions.php](admin/includes/functions.php)

**File Upload:**
- `uploadImage($file, $upload_dir, $max_size = 5242880)` - Validate and upload image files (max 5MB)

**Database Operations:**
- `insertRecord($table, $data)` - Insert new record
- `updateRecord($table, $data, $where)` - Update existing record
- `deleteRecord($table, $where)` - Delete record
- `getTableData($table, $where = '', $order_by = 'id DESC')` - Retrieve records

**Utilities:**
- `getITTeamList()` - Retrieve IT staff with details
- `formatDate($date)` - Format date for display
- `truncateText($text, $length)` - Truncate text with ellipsis

---

## 🛣️ Admin Panel Routes

Access admin features via URL parameters:

```
?page=dashboard         → Dashboard overview
?page=slideshow         → Banner/featured content
?page=systems           → IT systems management
?page=about             → Company information
?page=management        → Organizational hierarchy
?page=it_team           → Staff directory
?page=it_roster         → Staff scheduling
?page=it_special_days   → Holiday calendar
?page=slides            → E-learning content
?page=tickets           → Learning tickets
?page=news              → News management
?page=packages          → Services/packages
?page=sustainability    → Sustainability tracking
?page=extensions        → Phone directory
?page=staff             → Staff management
?page=navigation        → Navigation settings
?page=settings          → System configuration
```

---

## 📸 File Upload Guidelines

### Supported Formats
- **Images**: JPEG, PNG, GIF, WebP
- **Documents**: PDF (in designated folders)

### Size Limits
- **Maximum file size**: 5 MB
- **Recommended image dimensions**: 
  - News images: 1200x600px
  - Team photos: 400x400px (square)
  - System icons: 100x100px

### Upload Directories
```
uploads/
├── news/          # News article images
├── slideshow/     # Homepage banners
├── systems/       # System icons
├── it-team/       # Staff photos
├── management/    # Management photos
├── kpj/           # KPJ-specific content
└── [other categories/
```

---

## 🔒 Security Features

✅ **Implemented:**
- PDO prepared statements (SQL injection prevention)
- Session-based authentication (configurable timeout)
- File type validation (MIME type checking)
- File size restrictions
- Directory traversal protection

⚠️ **Recommendations:**
- Move database credentials to environment variables (`.env` file)
- Use HTTPS in production
- Implement CSRF tokens (currently basic)
- Regular database backups
- Update default admin credentials
- Implement rate limiting on login attempts

---

## 📝 Usage Examples

### Adding News
1. Login to admin panel (`/admin`)
2. Navigate to **News** section
3. Click "Add New News"
4. Fill in title, description, and upload image
5. Save and preview on public portal

### Managing Team Members
1. Go to **IT Team** section
2. Add/edit staff with:
   - Name, position, email
   - Phone number and extension
   - Professional photo
3. Changes appear on employee directory page

### Creating Holiday Calendar
1. Access **Special Days** section
2. Set weekly special days (5 per week option)
3. Add public holidays with dates
4. Portal displays holiday calendar automatically

---

## 🐛 Troubleshooting

### Database Connection Issues
- Verify MySQL server is running
- Check credentials in config files
- Ensure `company_portal` database exists

### File Upload Errors
- Verify `/uploads/` directory exists and has write permissions
- Check file size is under 5MB
- Confirm file is in supported format
- Ensure directory has proper CHMOD permissions (755)

### Admin Login Issues
- Verify cookies are enabled in browser
- Clear browser cache and try again
- Check `session.save_path` in PHP configuration

### Images Not Displaying
- Verify image path in database is correct
- Check image file actually exists in upload directory
- Confirm file permissions allow read access

---

## 📚 Documentation

For specific module documentation, refer to controller files:
- News management → [admin/controllers/about.php](admin/controllers/about.php)
- Team management → [admin/controllers/it_team.php](admin/controllers/it_team.php)
- Systems → [admin/controllers/systems.php](admin/controllers/systems.php)

---

## 🤝 Contributing

To contribute to MPortal:
1. Create a feature branch
2. Make changes with clear commit messages
3. Test thoroughly before submission
4. Submit pull request with description

---

## 📄 License

This project is proprietary software. Unauthorized copying or distribution is prohibited.

---

## 📞 Support

For support and questions:
- Check the troubleshooting section above
- Review controller and function documentation
- Contact the development team

---

## 📋 Changelog

### Version 1.0 (Initial Release)
- ✅ Admin dashboard with statistics
- ✅ Content management for all modules
- ✅ Public portal with responsive design
- ✅ File upload with validation
- ✅ User feedback and rating system
- ✅ Holiday and schedule management
- ✅ Dynamic navigation system

---

**Last Updated**: April 2026  
**Version**: 1.0  
**Status**: Production Ready
