# Setup Instructions

## Prerequisites

- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer

## Installation

1. **Install dependencies:**

   ```bash
   composer install
   ```

2. **Setup environment:**

   ```bash
   cp .env.example .env
   ```

   Edit `.env` file with your database credentials and security settings.

3. **Database setup:**

   ```bash
   # Import the original database structure
   mysql -u your_user -p your_database < src/admin/database/pekingco_data.sql

   # Run security migrations
   mysql -u your_user -p your_database < database/migrations/001_update_users_table.sql
   ```

4. **Create admin user:**

   ```sql
   -- Connect to your database and run:
   INSERT INTO users (username, password, email, active)
   VALUES ('admin', '$argon2id$v=19$m=65536,t=4,p=3$example', 'admin@example.com', 1);
   ```

   **Important:** Generate a proper password hash using the new system after first setup.

## Security Notes

- Change default database credentials in `.env`
- Generate a secure `APP_KEY` for production
- Use HTTPS in production (set `SESSION_SECURE=true`)
- Consider using a stronger `SALT` value

## File Structure Changes

- **New:** `src/app/` - Main application classes
- **New:** `src/admin/app/` - Admin-specific classes
- **New:** `database/migrations/` - Database migrations
- **Updated:** Admin files now use modern authentication and validation

## Usage

### Admin Login

Access `/admin/` and use the new secure login system.

### Menu Management

The admin dashboard now includes:

- CSRF protection on all forms
- Input validation
- Secure password hashing
- Session security
- Error logging

### Development

- Use `compass watch` for SASS compilation
- Check error logs in `src/admin/error_log`
- Environment-based configuration
