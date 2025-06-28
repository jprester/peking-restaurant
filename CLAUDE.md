# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a website for "Peking" Chinese restaurant, originally built in 2014. It's a classic PHP/MySQL web application with a responsive design and an admin dashboard for managing menu items.

## Architecture

### Frontend Structure
- **Main Site**: Located in `src/` directory
  - `index.php` - Homepage with image slider and restaurant info
  - `meni.php`, `meni_izbor.php` - Menu display pages
  - `kontakt.php`, `onama.php` - Contact and about pages
  - `inc/` - Shared includes (header.php, footer.php, jelovnik_list.php)

### Admin Dashboard
- **Location**: `src/admin/` directory
- **Architecture**: Object-oriented PHP with PDO database layer
- **Key Classes**:
  - `Db.php` - Base database connection class using PDO
  - `Meni.php` - Menu management (extends Db)
  - `Jelo.php` - Individual dish management (extends Db) 
  - `User.php` - User authentication (extends Db)
  - `Sessions.php` - Session management

### Database Schema
- **Engine**: MySQL with utf8_bin collation
- **Key Tables**:
  - `jela` - Dishes (jid, sort, broj, naziv, naziv_en, cijena, mid)
  - `meni` - Menu categories (mid, meni_ime, en_ime)
  - User authentication table (referenced in User.php)

### Styling & Assets
- **CSS Framework**: Uses Compass/SASS with config in `src/config.rb`
- **SASS Structure**: `src/sass/` with modular includes in `sass/include/`
- **Grid System**: Custom 12-column grid (grid_fixed.css, grid_fluid.css)
- **JavaScript**: jQuery 1.9.0, Nivo Slider for image carousel
- **Images**: Extensive image assets in `src/img/` and `src/admin/img/`

## Configuration

### Database Configuration
- **Admin Config**: `src/admin/config/config.php`
- **Main Config**: `src/admin/inc/dbconfig.php`
- Default settings: localhost, database 'peking', user 'root', pass 'root'

### SASS/CSS Compilation
- **Config**: `src/config.rb` (Compass configuration)
- **Output**: Compressed CSS to `css/` directory
- **Source**: SASS files in `sass/` directory

## Development Commands

### Initial Setup
```bash
# Install dependencies
composer install

# Setup environment
cp .env.example .env
# Edit .env with proper credentials

# Database setup
mysql -u root -p peking < src/admin/database/pekingco_data.sql
mysql -u root -p peking < database/migrations/001_update_users_table.sql
```

### CSS Development
```bash
# Compile SASS (from src/ directory)
compass compile

# Watch for SASS changes
compass watch
```

### Security Commands
```bash
# Generate secure password hash for admin user
php -r "echo password_hash('your_password', PASSWORD_ARGON2ID);"
```

## Key Features

- **Bilingual Support**: Croatian and English content throughout
- **Admin Dashboard**: Full CRUD operations for menu items and categories
- **Responsive Design**: Mobile-friendly layout with CSS grid system
- **Image Slider**: Nivo Slider implementation on homepage
- **Authentication**: Session-based admin login system with salted passwords

## File Organization

- **Frontend Pages**: Root level PHP files in `src/`
- **Admin System**: Completely separate in `src/admin/`
- **Shared Assets**: CSS, JS, and images in respective directories
- **Database Classes**: OOP structure in `src/admin/classes/`

## Modernization (2024)

### Security Improvements
- **Environment-based configuration** via `.env` files
- **Modern password hashing** with Argon2ID algorithm
- **CSRF protection** on all admin forms
- **Input validation and sanitization** using custom Validator class
- **Secure session management** with proper configuration
- **Database security** with prepared statements and error handling

### Code Architecture
- **Composer autoloading** with PSR-4 namespace structure
- **Modern Database class** with singleton pattern and full CRUD operations
- **MVC pattern** for admin controllers and views
- **Dependency injection** ready structure
- **Error logging** and exception handling
- **Database migrations** system for schema updates

### Backward Compatibility
- Original PHP files maintained for gradual migration
- Old classes still available during transition period
- Frontend/UI completely unchanged
- Database schema extended, not replaced

## Croatian Language Context

This is a Croatian restaurant website, so content is primarily in Croatian with English translations. Menu items, page titles, and admin interface are in Croatian.