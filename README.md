# Peking Website

Website for "Peking" Chinese restaurant in Zagreb, Croatia.

2014-2017 (original) / 2026 (app rework)

## App Rework (2026)

Complete rebuild from legacy PHP pages to a modern MVC architecture with REST API
backend, Alpine.js admin dashboard, and responsive front-end.

Highlights:

- PHP 8 MVC backend with clean URL routing and PDO database access.
- REST API for categories, dishes, and combo menus with session auth + CSRF.
- Admin dashboard (Alpine.js + Tailwind CDN) for content management.
- Responsive front-end with mobile hamburger nav and category picker.
- Bilingual menu display (Croatian + English).
- Security: bcrypt passwords, prepared statements, CSRF tokens, XSS escaping.

Full technical docs: docs/app-rework.md
Deployment guide: docs/deployment.md

## Tech Stack

- **Backend:** PHP 7.0+ (custom MVC, no framework)
- **Database:** MySQL 5.7+ / MariaDB 10.3+ (utf8mb4)
- **Admin UI:** Alpine.js + Tailwind CSS (CDN, no build step)
- **Front-end:** Vanilla JS, custom CSS (flexbox/grid)

## Local Development Setup

1. Copy `app/config.php.example` to `app/config.php` and set your DB credentials.
2. Import `database/schema.sql` or run `database/migrate.php` to create tables and seed data.
3. Point your web server document root to `/public`.
4. For subfolder setups (e.g., MAMP), update `RewriteBase` in `public/.htaccess`.

## Project Structure

```
peking/
├── app/                    # Application code (outside web root)
│   ├── bootstrap.php       # Autoloading, config, session, BASE_URL detection
│   ├── Router.php          # Lightweight URL router
│   ├── config.php.example  # Config template
│   ├── Controllers/        # Page + API controllers
│   ├── Models/             # PDO data access layer
│   ├── Middleware/          # Auth, CSRF helpers
│   └── Views/              # PHP templates (layout, pages, partials)
├── public/                 # Web root (document root points here)
│   ├── index.php           # Front controller
│   ├── .htaccess           # URL rewriting
│   ├── admin/              # Admin SPA (Alpine.js + Tailwind)
│   ├── css/style.css       # Site styles
│   ├── js/pekingScripts.js # Mobile nav, slider
│   └── img/                # Images and assets
├── database/
│   ├── schema.sql          # Database schema
│   └── migrate.php         # Legacy data migration script
└── docs/                   # Documentation
```

version: 0.05

author: Janko Prester (janko.prester@gmail.com)
