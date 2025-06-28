#!/bin/bash

# Simple script to run the Peking Restaurant website locally

echo "🍜 Starting Peking Restaurant Website..."
echo ""

# Check if PHP is available
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 8.1 or higher."
    exit 1
fi

# Check PHP version
php_version=$(php -r "echo PHP_VERSION;" 2>/dev/null)
echo "✅ PHP Version: $php_version"

# Check if composer dependencies are installed
if [ ! -d "vendor" ]; then
    echo "⚠️  Dependencies not installed. Running composer install..."
    if command -v composer &> /dev/null; then
        composer install
    else
        echo "❌ Composer not found. Please install composer first."
        exit 1
    fi
fi

# Check if .env exists
if [ ! -f ".env" ]; then
    echo "⚠️  .env file not found. Copying from .env.example..."
    cp .env.example .env
    echo "📝 Please edit .env file with your database credentials"
fi

echo ""
echo "🚀 Starting PHP development server..."
echo "📍 Website URL: http://localhost:8000"
echo "🔧 Admin URL: http://localhost:8000/admin/"
echo ""
echo "Press Ctrl+C to stop the server"
echo ""

# Start PHP development server from src directory
cd src && php -S localhost:8000