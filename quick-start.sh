#!/bin/bash

# Quick Start Script untuk ERP di Synology NAS
# Jalankan script ini setelah upload project ke /volume1/docker/erp/

set -e

echo "🚀 Starting ERP Deployment on Synology NAS..."

# Check if we're in the right directory
if [ ! -f "docker-compose.simple.yml" ]; then
    echo "❌ Error: docker-compose.simple.yml not found!"
    echo "Please run this script from /volume1/docker/erp/ directory"
    exit 1
fi

# Create directories if not exist
mkdir -p storage/logs
mkdir -p storage/app/public
mkdir -p public/uploads
mkdir -p bootstrap/cache

# Set permissions
chmod -R 775 storage bootstrap/cache

echo "📁 Directories and permissions set"

# Copy environment file if not exists
if [ ! -f ".env" ]; then
    if [ -f ".env.production" ]; then
        cp .env.production .env
        echo "📋 Environment file copied from .env.production"
    elif [ -f ".env.example" ]; then
        cp .env.example .env
        echo "📋 Environment file copied from .env.example"
    else
        echo "❌ No environment file found! Please create .env file"
        exit 1
    fi
fi

# Update .env with local settings
echo "⚙️  Updating environment configuration..."
sed -i 's/DB_HOST=.*/DB_HOST=mysql/' .env
sed -i 's/DB_DATABASE=.*/DB_DATABASE=erp_db/' .env
sed -i 's/DB_USERNAME=.*/DB_USERNAME=erp_user/' .env
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=erppassword123/' .env
sed -i 's/REDIS_HOST=.*/REDIS_HOST=redis/' .env

# Get Synology IP for APP_URL
SYNOLOGY_IP=$(ip route get 1.1.1.1 | awk '{print $7; exit}')
sed -i "s|APP_URL=.*|APP_URL=http://${SYNOLOGY_IP}:8080|" .env

echo "🐳 Starting Docker containers..."
docker-compose -f docker-compose.simple.yml up -d

# Wait for MySQL to be ready
echo "⏳ Waiting for database to be ready..."
sleep 30

# Run Laravel setup inside container
echo "🔧 Setting up Laravel application..."
docker-compose -f docker-compose.simple.yml exec -T app bash << 'EOF'
# Generate app key if not exists
if grep -q "APP_KEY=$" .env || grep -q "APP_KEY=base64:$" .env; then
    php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force

# Install Passport
php artisan passport:install --force

# Cache configuration
php artisan config:cache
php artisan route:cache

# Create admin user if not exists
php artisan tinker --execute="
if (!\App\User::where('username', 'admin')->exists()) {
    \App\User::create([
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password' => \Hash::make('admin123'),
        'first_name' => 'System',
        'last_name' => 'Administrator',
        'business_id' => 1,
        'is_active' => 1
    ]);
    echo 'Admin user created: username=admin, password=admin123';
} else {
    echo 'Admin user already exists';
}
"
EOF

echo ""
echo "✅ ERP deployment completed successfully!"
echo ""
echo "🌐 Access your ERP at: http://${SYNOLOGY_IP}:8080"
echo "👤 Login credentials:"
echo "   Username: admin"
echo "   Password: admin123"
echo ""
echo "📊 Container status:"
docker-compose -f docker-compose.simple.yml ps
echo ""
echo "📝 Next steps:"
echo "1. Change admin password after first login"
echo "2. Configure business settings"
echo "3. Setup SSL certificate for production"
echo "4. Configure automated backups"
echo ""
echo "🔍 Logs:"
echo "   Application: docker-compose -f docker-compose.simple.yml logs app"
echo "   Database: docker-compose -f docker-compose.simple.yml logs mysql"
echo ""
