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

# Check if Node.js dependencies are installed
if [ ! -d "node_modules" ]; then
    echo "⚠️  Node.js dependencies not installed. Running npm install..."
    if command -v npm &> /dev/null; then
        npm install
    else
        echo "❌ npm not found. Please install Node.js first."
        exit 1
    fi
fi

# Function to compile SCSS
compile_scss() {
    echo "🎨 Compiling SCSS to CSS..."
    npm run build-css
    echo "✅ CSS compilation complete!"
}

# Function to watch SCSS changes
watch_scss() {
    echo "👀 Starting SCSS watcher..."
    echo "📁 Watching for changes in src/sass/"
    npm run watch-css &
    SCSS_PID=$!
    echo "✅ SCSS watcher started (PID: $SCSS_PID)"
}

# Check command line arguments
if [ "$1" = "--compile" ]; then
    compile_scss
    exit 0
elif [ "$1" = "--watch" ]; then
    watch_scss
elif [ "$1" = "--build" ]; then
    compile_scss
    echo ""
    echo "🚀 Starting PHP development server..."
    echo "📍 Website URL: http://localhost:8000"
    echo "🔧 Admin URL: http://localhost:8000/admin/"
    echo ""
    echo "Press Ctrl+C to stop the server"
    echo ""
    cd src && php -S localhost:8000
    exit 0
fi

# Default behavior: compile CSS once and start server
compile_scss

echo ""
echo "🚀 Starting PHP development server..."
echo "📍 Website URL: http://localhost:8000"
echo "🔧 Admin URL: http://localhost:8000/admin/"
echo ""
echo "💡 Usage options:"
echo "   ./run-local.sh          - Compile CSS once and start server"
echo "   ./run-local.sh --watch  - Watch SCSS changes and start server"
echo "   ./run-local.sh --compile - Only compile CSS"
echo "   ./run-local.sh --build  - Compile CSS and start server"
echo ""
echo "Press Ctrl+C to stop the server"
echo ""

# Start PHP development server from src directory
cd src && php -S localhost:8000