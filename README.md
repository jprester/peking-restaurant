# Peking Website

Website for "Peking" Chinese restaurant.

2014-2017 (original) / 2026 (app rework)

## App Rework (2026)

This branch introduces a modernized PHP app under /app with a small MVC layer,
JSON APIs for the admin dashboard, and a refreshed front-end layout and CSS.

Highlights:

- New /app structure (bootstrap, router, controllers, models, views).
- Public entry point at /public/index.php with clean page routes.
- JSON APIs for categories, dishes, and combo menus, with auth + CSRF.
- Admin dashboard at /public/admin (Alpine.js + Tailwind) using the APIs.
- Updated CSS layout using flex/grid and a mobile-first header/menu.
- Class naming cleanup: English class names; IDs reserved for JS hooks.

Full rework documentation: docs/app-rework.md

## Features

- Responsive design
- Admin dashboard for editing menu items made with PHP & MySql

## Setup (local)

1. Copy app/config.php.example to app/config.php and set DB credentials.
2. Import database/schema.sql or run database/migrate.php to create tables.
3. Point your web server docroot to /public.

version: 0.04

author: Janko Prester (janko.prester@gmail.com)
