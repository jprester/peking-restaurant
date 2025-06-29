#!/bin/bash

# Format all PHP files in the project
echo "Formatting all PHP files with Prettier..."

# Find all PHP files and format them
find src/ -name "*.php" -type f -exec npx prettier --write {} \;

echo "Formatting complete!" 