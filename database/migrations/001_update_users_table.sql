-- Update users table for modern security features
-- Run this migration to update the existing users table

-- Add new columns if they don't exist
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS email VARCHAR(255) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS last_login DATETIME DEFAULT NULL,
ADD COLUMN IF NOT EXISTS last_ip VARCHAR(45) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS active TINYINT(1) DEFAULT 1,
ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Add indexes for better performance
CREATE INDEX IF NOT EXISTS idx_users_username ON users(username);
CREATE INDEX IF NOT EXISTS idx_users_active ON users(active);
CREATE INDEX IF NOT EXISTS idx_users_last_login ON users(last_login);

-- Update existing users to be active
UPDATE users SET active = 1 WHERE active IS NULL;

-- Note: Existing passwords will be upgraded to modern hashing on first login