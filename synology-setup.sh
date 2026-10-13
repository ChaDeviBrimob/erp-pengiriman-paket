#!/bin/bash

# Synology NAS Setup Script
# Run this script via SSH to prepare your Synology NAS for ERP deployment

echo "=== Synology NAS ERP Setup Script ==="
echo "Setting up directories and permissions..."

# Create main directories
sudo mkdir -p /volume1/docker/erp
sudo mkdir -p /volume1/docker/erp-mysql
sudo mkdir -p /volume1/docker/erp-redis
sudo mkdir -p /volume1/backup/erp
sudo mkdir -p /volume1/ssl/erp

# Set permissions
sudo chown -R admin:users /volume1/docker/erp*
sudo chown -R admin:users /volume1/backup/erp
sudo chown -R admin:users /volume1/ssl/erp

# Create docker network
docker network create erp-network 2>/dev/null || echo "Network already exists"

echo "✅ Directories created successfully!"
echo ""
echo "Next steps:"
echo "1. Upload your ERP project to /volume1/docker/erp/"
echo "2. Configure .env file"
echo "3. Run docker-compose up -d"
echo ""
echo "Directories created:"
echo "- /volume1/docker/erp (main application)"
echo "- /volume1/docker/erp-mysql (database storage)"
echo "- /volume1/docker/erp-redis (cache storage)"
echo "- /volume1/backup/erp (automated backups)"
echo "- /volume1/ssl/erp (SSL certificates)"
