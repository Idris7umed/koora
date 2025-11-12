#!/bin/bash

echo "🚀 Setting up Koora Soccer Platform..."
echo ""

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if we're in the right directory
if [ ! -d "backend" ] || [ ! -d "frontend" ]; then
    echo -e "${RED}Error: Please run this script from the project root directory${NC}"
    exit 1
fi

# Backend Setup
echo -e "${BLUE}📦 Setting up Backend...${NC}"
cd backend

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo -e "${RED}Error: Composer is not installed. Please install Composer first.${NC}"
    exit 1
fi

# Install dependencies
echo "Installing PHP dependencies..."
composer install --no-interaction --optimize-autoloader

# Setup environment file
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
fi

# Generate application key
echo "Generating application key..."
php artisan key:generate --no-interaction

# Create database
if [ ! -f database/database.sqlite ]; then
    echo "Creating SQLite database..."
    touch database/database.sqlite
fi

# Run migrations
echo "Running migrations..."
php artisan migrate:fresh --seed --force

echo -e "${GREEN}✅ Backend setup complete!${NC}"
echo ""

# Frontend Setup
cd ../frontend
echo -e "${BLUE}📦 Setting up Frontend...${NC}"

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo -e "${RED}Error: npm is not installed. Please install Node.js and npm first.${NC}"
    exit 1
fi

# Install dependencies
echo "Installing Node.js dependencies..."
npm install

# Setup environment file
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
fi

echo -e "${GREEN}✅ Frontend setup complete!${NC}"
echo ""

cd ..

echo -e "${GREEN}🎉 Setup completed successfully!${NC}"
echo ""
echo "To start the application:"
echo ""
echo "1. Start the backend (in one terminal):"
echo -e "   ${BLUE}cd backend && php artisan serve${NC}"
echo ""
echo "2. Start the frontend (in another terminal):"
echo -e "   ${BLUE}cd frontend && npm run dev${NC}"
echo ""
echo "3. Open your browser:"
echo -e "   ${BLUE}http://localhost:5173${NC}"
echo ""
echo "📖 For more information, see QUICKSTART.md"
