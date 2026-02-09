# App Rework Notes (2026)

This document describes the modern app rework that lives under /app and the
related front-end changes in /public.

## Goals

- Replace the legacy PHP pages with a small MVC structure.
- Add JSON APIs for content management.
- Refresh the public site layout, responsiveness, and CSS structure.
- Keep the legacy /src code intact for reference.

## Project Layout (Reworked App)

- /app
  - bootstrap.php: app bootstrapping, autoloading, BASE_URL detection.
  - Router.php: lightweight route matcher.
  - Controllers
    - PageController.php: public pages.
    - Api/\*: JSON endpoints for auth, categories, dishes, combo menus.
  - Models: PDO-backed data access for categories, dishes, combo menus, users.
  - Views: layout (header/footer) + page templates.
  - Middleware: Auth and CSRF helpers.
- /public
  - index.php: front controller that wires routes.
  - css/style.css: refreshed layout, class naming, responsive tweaks.
  - js/pekingScripts.js: mobile nav + slider logic.
  - admin/index.html: Alpine.js + Tailwind CMS UI.
- /database
  - schema.sql: new schema.
  - migrate.php: import legacy data into the new schema.

## Public Routes

- / (home)
- /about
- /menu
- /menu/{id}
- /menu/combo/{personCount}
- /contact

## API Routes

Auth

- GET /api/auth/me
- POST /api/auth/login
- POST /api/auth/logout
- POST /api/auth/change-password

Categories

- GET /api/categories
- GET /api/categories/{id}
- POST /api/categories
- PUT /api/categories/{id}
- DELETE /api/categories/{id}
- POST /api/categories/reorder

Dishes

- GET /api/dishes
- GET /api/dishes/{id}
- POST /api/dishes
- PUT /api/dishes/{id}
- DELETE /api/dishes/{id}
- POST /api/dishes/reorder

Combo Menus

- GET /api/comboMenus
- GET /api/comboMenus/{id}
- POST /api/comboMenus
- PUT /api/comboMenus/{id}
- DELETE /api/comboMenus/{id}
- POST /api/comboMenus/{id}/items
- PUT /api/comboMenus/{id}/items/{itemId}
- DELETE /api/comboMenus/{id}/items/{itemId}

## Admin Dashboard

- Location: /public/admin/index.html
- UI stack: Alpine.js + Tailwind (CDN)
- Uses JSON APIs for CRUD and ordering operations.
- CSRF token is returned on login and passed via X-CSRF-Token.

## Data Model

- categories: menu categories (Cro + En name, sort order)
- dishes: menu items by category (number, Cro/En name, price, sort order)
- comboMenus: grouped menus by person count (price, names)
- comboMenuItems: items within a combo menu
- users: CMS users (password hash)

## Migration

- database/schema.sql creates the new schema.
- database/migrate.php can import from legacy tables (meni, jela, user).
  It also seeds combo menus based on legacy PHP content.

## Front-End Updates

- Mobile header with a hamburger nav toggle.
- Menu category sidebar plus mobile category picker.
- Crossfade hero slider.
- Grid/flex layout for responsive content blocks.

## CSS and Naming Conventions

- Styling hooks use classes; IDs are reserved for JS selectors.
- Class names use English kebab-case.
- JS IDs use camelCase.

Examples of renamed classes:

- txt1, txt2, txt3 -> text-primary, text-secondary, text-body
- dtitle -> section-title
- meni-list -> menu-list
- jelovnik -> dish-menu
- meni-table -> menu-table
- table_naslov -> table-title
- td-broj -> td-number
- td-jelo -> td-dish
- td-cijena -> td-price
- t_bottom -> table-bottom

## Legacy Code

- /src contains the older PHP pages and assets.
- The reworked app does not depend on /src at runtime.
