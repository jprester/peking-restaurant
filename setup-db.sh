#!/bin/bash

# Quick database setup script for Peking Restaurant

echo "🗄️  Setting up Peking Restaurant Database..."
echo ""

# Get database credentials
read -p "Enter MySQL username [root]: " db_user
db_user=${db_user:-root}

read -s -p "Enter MySQL password: " db_pass
echo ""

read -p "Enter database name [peking]: " db_name
db_name=${db_name:-peking}

# Create database if it doesn't exist
echo "📝 Creating database '$db_name'..."
mysql -u "$db_user" -p"$db_pass" -e "CREATE DATABASE IF NOT EXISTS $db_name CHARACTER SET utf8 COLLATE utf8_general_ci;"

# Import original schema
echo "📥 Importing original database structure..."
mysql -u "$db_user" -p"$db_pass" "$db_name" < src/admin/database/pekingco_data.sql

# Run migrations
echo "🔄 Running security migrations..."
mysql -u "$db_user" -p"$db_pass" "$db_name" < database/migrations/001_update_users_table.sql

# Generate admin password hash
echo ""
read -s -p "Enter admin password: " admin_pass
echo ""

admin_hash=$(php -r "echo password_hash('$admin_pass', PASSWORD_ARGON2ID);")

# Create admin user
echo "👤 Creating admin user..."
mysql -u "$db_user" -p"$db_pass" "$db_name" -e "
INSERT INTO users (username, password, email, active) 
VALUES ('admin', '$admin_hash', 'admin@peking.local', 1)
ON DUPLICATE KEY UPDATE password='$admin_hash', active=1;"

# Update .env file
echo "📝 Updating .env file..."
sed -i.bak "s/DB_USER=.*/DB_USER=$db_user/" .env
sed -i.bak "s/DB_PASS=.*/DB_PASS=$db_pass/" .env
sed -i.bak "s/DB_NAME=.*/DB_NAME=$db_name/" .env

echo ""
echo "✅ Database setup complete!"
echo "👤 Admin credentials: admin / [your password]"
echo "🌐 Access admin at: http://localhost:8000/admin/"
echo ""