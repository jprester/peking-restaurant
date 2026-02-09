# AI Agent Notes (App Rework)

This file is a quick guide for AI agents working on the modernized /app codebase.
Scope: app rework only (ignore legacy /src unless explicitly asked).

## Project Overview

- Entry point: /public/index.php
- App root: /app (MVC-ish structure)
- Views: /app/Views (header/footer + pages + partials)
- Public assets: /public/css/style.css, /public/js/pekingScripts.js
- Admin UI: /public/admin/index.html (Alpine.js + Tailwind CDN)
- Database: /database/schema.sql, /database/migrate.php

## Tooling and Runtime

- PHP app intended to run under a web server with docroot at /public.
- No build step for the public site.
- Admin uses CDN assets (Alpine.js, Tailwind).

## Key Routes

Public pages:

- /, /about, /menu, /menu/{id}, /menu/combo/{personCount}, /contact

APIs:

- /api/auth/_, /api/categories/_, /api/dishes/_, /api/comboMenus/_

## Coding Standards

- PHP: keep logic in controllers/models; views are mostly markup.
- CSS: use class selectors for styling; reserve IDs for JS selectors.
- Naming: English, kebab-case for classes; camelCase for JS IDs.
- JS: vanilla, no external build tooling.
- Keep changes small and localized; avoid touching /src unless asked.

## Security and Data Handling

- API mutations require Auth + CSRF.
- CSRF token returned on login and passed via X-CSRF-Token.
- Validate inputs server-side (see Api controllers).

## Data Model Summary

- categories (nameCro, nameEn, sortOrder)
- dishes (categoryId, dishNumber, nameCro, nameEn, price, sortOrder)
- comboMenus (name, nameCro, nameEn, personCount, price, sortOrder)
- comboMenuItems (comboMenuId, itemNumber, nameCro, nameEn, sortOrder)
- users (username, passwordHash)

## Migration

- Use /database/schema.sql to create tables.
- /database/migrate.php can import legacy tables (meni, jela, user) and seed combos.

## UX/Styling Notes

- Mobile header uses JS toggles in /public/js/pekingScripts.js.
- Menu category sidebar has a mobile dropdown.
- CSS is tuned for the refreshed layout; avoid large design changes unless requested.

## Testing

- No automated test suite is currently configured.
- Manual spot-check: home, menu, menu category, combo menu, contact, admin login.
