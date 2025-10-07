#!/bin/bash

echo "========================================"
echo "   Study Programs System Setup"
echo "========================================"
echo

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}✓${NC} $1"
}

print_error() {
    echo -e "${RED}✗${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

print_info() {
    echo -e "${BLUE}ℹ${NC} $1"
}

# Check if we're in Laravel project directory
if [ ! -f "artisan" ]; then
    print_error "Please run this script from the Laravel project root directory."
    exit 1
fi

echo "[1/5] Running Migration..."
php artisan migrate --path=database/migrations/2024_01_15_000000_create_study_programs_table.php
if [ $? -eq 0 ]; then
    print_status "Migration completed successfully!"
else
    print_error "Migration failed!"
    exit 1
fi
echo

echo "[2/5] Creating Storage Directories..."
mkdir -p storage/app/public/study-programs/images
mkdir -p storage/app/public/study-programs/brochures
print_status "Storage directories created!"
echo

echo "[3/5] Creating Storage Link..."
php artisan storage:link
print_status "Storage link created!"
echo

echo "[4/5] Running Seeder..."
php artisan db:seed --class=StudyProgramSeeder
if [ $? -eq 0 ]; then
    print_status "Seeder completed successfully!"
else
    print_warning "Seeder failed, but continuing..."
fi
echo

echo "[5/5] Clearing Cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
print_status "Cache cleared!"
echo

echo "========================================"
echo "   Setup Completed Successfully!"
echo "========================================"
echo
print_info "You can now access:"
echo "- Admin Panel: /admin/study-programs"
echo "- Public Page: /study-programs"
echo
print_info "Next steps:"
echo "1. Configure file upload settings if needed"
echo "2. Set up proper permissions for storage directories"
echo "3. Test the system by creating a new study program"
echo

# Set proper permissions for storage directories
echo "Setting storage permissions..."
chmod -R 755 storage/app/public/study-programs/
print_status "Storage permissions set!"
echo

echo "🎉 All done! Happy coding!"