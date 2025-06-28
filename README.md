# Peking Restaurant Website

A modernized website for "Peking" Chinese restaurant, originally built in 2014 and significantly updated in 2025.

## 🚀 Features

- **Responsive Design** - Mobile-friendly layout with CSS grid system
- **Admin Dashboard** - Secure menu management system with modern authentication
- **Bilingual Support** - Croatian and English content throughout
- **Image Slider** - Nivo Slider implementation on homepage
- **Modern Security** - CSRF protection, input validation, secure password hashing
- **Database Migrations** - Structured database updates and schema management

## 🛠️ Technology Stack

- **Backend**: PHP 8.1+ with modern OOP architecture
- **Database**: MySQL 5.7+ with PDO
- **Frontend**: HTML5, CSS3 (SASS/Compass), jQuery
- **Security**: Argon2ID password hashing, CSRF protection, input validation
- **Dependencies**: Composer with PSR-4 autoloading

## 📋 Prerequisites

- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer
- Web server (Apache/Nginx)

## 🚀 Quick Start

1. **Clone and install dependencies:**

   ```bash
   git clone <repository-url>
   cd peking-restaurant
   composer install
   ```

2. **Setup environment:**

   ```bash
   cp .env.example .env
   # Edit .env with your database credentials
   ```

3. **Database setup:**

   ```bash
   # Import original database structure
   mysql -u your_user -p your_database < src/admin/database/pekingco_data.sql

   # Run security migrations
   mysql -u your_user -p your_database < database/migrations/001_update_users_table.sql
   ```

4. **Create admin user:**
   ```sql
   INSERT INTO users (username, password, email, active)
   VALUES ('admin', '$argon2id$v=19$m=65536,t=4,p=3$example', 'admin@example.com', 1);
   ```

## 🔧 Development

### CSS Development

```bash
# From src/ directory
compass compile
compass watch
```

### Security Features

- Environment-based configuration
- Modern password hashing (Argon2ID)
- CSRF protection on all forms
- Input validation and sanitization
- Secure session management
- Database security with prepared statements

### Architecture

- **Frontend**: Classic PHP structure in `src/`
- **Admin**: Modern MVC pattern in `src/admin/app/`
- **Database**: OOP layer with PDO in `src/admin/classes/`
- **Assets**: SASS compilation with Compass

## 📁 Project Structure

```
peking-restaurant/
├── src/                    # Main website files
│   ├── admin/             # Admin dashboard
│   │   ├── app/           # Modern admin classes
│   │   ├── classes/       # Legacy database classes
│   │   └── database/      # Database files
│   ├── app/               # Main application classes
│   ├── sass/              # SASS source files
│   └── img/               # Image assets
├── database/
│   └── migrations/        # Database migrations
├── composer.json          # PHP dependencies
└── .env.example          # Environment configuration
```

## 🔒 Security Notes

- Change default database credentials in `.env`
- Generate a secure `APP_KEY` for production
- Use HTTPS in production (set `SESSION_SECURE=true`)
- Consider using a stronger `SALT` value
- Regularly update dependencies

## 📖 Documentation

- [Setup Instructions](SETUP.md) - Detailed installation guide
- [CLAUDE.md](CLAUDE.md) - Development documentation and architecture overview

## 👨‍💻 Author

**Janko Prester** (janko.prester@gmail.com)

**Version**: 1.0.0 (Modernized 2025)

---

_Originally built in 2014, modernized with security improvements and modern PHP architecture in 2025._
