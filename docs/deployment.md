# Deployment Guide

This document covers deploying the Peking restaurant website to production.

## Requirements

- PHP 7.0+ (recommended: 8.0 or 8.1)
- MySQL 5.7+ or MariaDB 10.3+
- Apache with mod_rewrite enabled
- PHP extensions: pdo, pdo_mysql, mbstring

## Deployment Strategy

The recommended approach is a two-stage process:

1. **Stage 1 — Demo on VPS:** Deploy to a VPS for client review and testing.
2. **Stage 2 — Production on cPanel:** Once approved, deploy to the client's
   cPanel shared hosting.

---

## Stage 1: VPS Demo Deployment

### 1.1 Server setup

Install Apache, PHP, and MySQL on the VPS (Ubuntu/Debian example):

```bash
sudo apt update
sudo apt install apache2 php php-mysql php-mbstring libapache2-mod-php mariadb-server
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 1.2 Upload files

Upload the project (excluding legacy code) to the server:

```
/var/www/peking/
├── app/
├── public/
└── database/
```

Do NOT upload:
- `src/` (legacy code with hardcoded credentials)
- `app/config.php` (create it on the server)
- `.git/`, `.claude/`, `node_modules/` (dev artifacts)

### 1.3 Configure Apache virtual host

Create `/etc/apache2/sites-available/peking.conf`:

```apache
<VirtualHost *:80>
    ServerName your-vps-ip-or-domain
    DocumentRoot /var/www/peking/public

    <Directory /var/www/peking/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Enable it:

```bash
sudo a2ensite peking.conf
sudo a2dissite 000-default.conf
sudo systemctl reload apache2
```

### 1.4 Set up the database

```bash
sudo mysql -u root
```

```sql
CREATE DATABASE peking CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'peking_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON peking.* TO 'peking_user'@'localhost';
FLUSH PRIVILEGES;
```

Import the schema:

```bash
mysql -u peking_user -p peking < /var/www/peking/database/schema.sql
```

### 1.5 Create config file

```bash
cp /var/www/peking/app/config.php.example /var/www/peking/app/config.php
```

Edit `config.php` with production values:

```php
return [
    'db' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'name' => 'peking',
        'user' => 'peking_user',
        'pass' => 'strong_password_here',
        'charset' => 'utf8mb4',
    ],
    'app' => [
        'baseUrl' => '',
        'debug' => false,     // MUST be false in production
    ],
];
```

### 1.6 Update .htaccess

Edit `public/.htaccess` and set:

```
RewriteBase /
```

### 1.7 Set file permissions

```bash
sudo chown -R www-data:www-data /var/www/peking
sudo chmod -R 755 /var/www/peking
sudo chmod 640 /var/www/peking/app/config.php
```

### 1.8 Seed initial data

Option A — Run the migration script (imports legacy data):

```bash
php /var/www/peking/database/migrate.php
```

Option B — Import schema only and add data via the admin panel:

```bash
mysql -u peking_user -p peking < /var/www/peking/database/schema.sql
```

Then manually insert an admin user:

```sql
INSERT INTO users (username, passwordHash)
VALUES ('admin', '$2y$10$...');  -- use: php -r "echo password_hash('your_password', PASSWORD_BCRYPT);"
```

### 1.9 Change admin password

If you used migrate.php (which creates admin/admin123), log in to `/admin` and
change the password immediately.

### 1.10 Test

Verify all pages work:
- Homepage: `http://your-vps/`
- About: `http://your-vps/about`
- Menu: `http://your-vps/menu`
- A category: `http://your-vps/menu/1`
- Combo menu: `http://your-vps/menu/combo/2`
- Contact: `http://your-vps/contact`
- Admin login: `http://your-vps/admin`
- Mobile: test on phone or with browser dev tools

---

## Stage 2: cPanel Production Deployment

### 2.1 Prepare cPanel hosting

1. **Upgrade PHP** to 8.0+ via cPanel > PHP Selector.
2. Ensure these PHP extensions are enabled: pdo, pdo_mysql, mbstring.

### 2.2 Directory structure on cPanel

On cPanel, `public_html` is the document root. The app code goes OUTSIDE it:

```
/home/username/
├── peking-app/             # Upload /app and /database here
│   ├── bootstrap.php
│   ├── config.php          # Create on server (not in git)
│   ├── config.php.example
│   ├── Router.php
│   ├── Controllers/
│   ├── Models/
│   ├── Middleware/
│   ├── Views/
│   └── ...
├── peking-db/              # Upload /database here
│   ├── schema.sql
│   └── migrate.php
└── public_html/            # Upload contents of /public here
    ├── index.php           # Needs path adjustment (see below)
    ├── .htaccess
    ├── admin/
    ├── css/
    ├── js/
    └── img/
```

### 2.3 Adjust paths in index.php

Since `/app` is no longer at `../app` relative to `public_html`, update the
require path in `public_html/index.php`:

```php
// Change this line:
require_once __DIR__ . '/../app/bootstrap.php';

// To:
require_once '/home/username/peking-app/bootstrap.php';
```

Also update `APP_ROOT` references if bootstrap.php uses `__DIR__`:
In `bootstrap.php`, `APP_ROOT` is `__DIR__` which will correctly resolve to
`/home/username/peking-app/` — no change needed there.

### 2.4 Update .htaccess

Set RewriteBase for the domain root:

```
RewriteBase /
```

### 2.5 Create database

1. Go to cPanel > Manage My Databases (or Database Wizard).
2. Create a new database (e.g., `pekingco_peking`).
3. Create a database user with a strong password.
4. Assign the user to the database with ALL PRIVILEGES.
5. Import `schema.sql` via cPanel > phpMyAdmin.

### 2.6 Create config.php

Create `/home/username/peking-app/config.php`:

```php
<?php
return [
    'db' => [
        'host' => 'localhost',
        'port' => '3306',
        'name' => 'pekingco_peking',
        'user' => 'pekingco_dbuser',
        'pass' => 'your_strong_password',
        'charset' => 'utf8mb4',
    ],
    'app' => [
        'baseUrl' => '',
        'debug' => false,
    ],
];
```

### 2.7 Seed data

Option A — Run migration via SSH (if available):

```bash
php /home/username/peking-db/migrate.php
```

Option B — Import via phpMyAdmin, then add admin user.

### 2.8 Change admin password

Log in at `https://peking.hr/admin` and change the default password.

### 2.9 Remove old site

Once the new site is confirmed working:

1. Back up the old `public_html` contents (download via File Manager or FTP).
2. Delete old files that are no longer needed.
3. The old `/src` directory should NOT be uploaded at all.

### 2.10 Final verification

- [ ] All pages load correctly (home, about, menu, categories, combo, contact)
- [ ] Admin panel login works at `/admin`
- [ ] CRUD operations work (add/edit/delete dishes, categories, combos)
- [ ] Mobile navigation works (hamburger menu, category dropdown)
- [ ] Images display correctly
- [ ] HTTPS works (if SSL is configured)
- [ ] Debug mode is OFF (`debug => false`)

---

## Optional: Security Headers

Add to `public/.htaccess` (or `public_html/.htaccess` on cPanel):

```apache
<IfModule mod_headers.c>
    Header set X-Frame-Options "DENY"
    Header set X-Content-Type-Options "nosniff"
    Header set X-XSS-Protection "1; mode=block"
    Header set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>
```

## Optional: Browser Caching

Add to `.htaccess`:

```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/x-icon "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

---

## Rollback Plan

If something goes wrong after deploying to cPanel:

1. Restore the old `public_html` from your backup.
2. Downgrade PHP back to 5.6 if needed (via PHP Selector).
3. The old database should still be intact (the new app uses a separate database).

## Switching from VPS Demo to cPanel

When transitioning from VPS demo to final cPanel deployment:

1. Export the database from VPS: `mysqldump -u peking_user -p peking > backup.sql`
2. Import into cPanel via phpMyAdmin (this preserves any menu edits made during testing).
3. Upload files to cPanel as described in Stage 2.
4. Verify everything works, then decommission the VPS demo.
