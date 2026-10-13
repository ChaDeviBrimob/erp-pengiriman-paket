# 🚀 Synology NAS Deployment Guide

## STEP 2: Upload Project ke Synology

### Method 1: Via SCP (Recommended)
```bash
# Dari Windows PowerShell/CMD
scp -r C:\xampp\htdocs\erp admin@[SYNOLOGY-IP]:/volume1/docker/

# Contoh dengan IP:
scp -r C:\xampp\htdocs\erp admin@192.168.1.100:/volume1/docker/
```

### Method 2: Via File Station (GUI)
1. Buka browser, akses http://[SYNOLOGY-IP]:5000
2. Login dengan admin account
3. Buka **File Station**
4. Navigate ke folder `/docker`
5. Create folder `erp` jika belum ada
6. Upload semua file project ke folder `erp`

### Method 3: Via Shared Folder
1. Di DSM, buka **Control Panel** → **Shared Folder**
2. Create shared folder bernama `docker`
3. Di Windows, map network drive:
   - `\\[SYNOLOGY-IP]\docker`
4. Copy paste folder `erp` ke network drive

## STEP 3: SSH ke Synology dan Setup

```bash
# SSH ke Synology
ssh admin@[SYNOLOGY-IP]

# Navigate ke project directory
cd /volume1/docker/erp

# Run setup script
chmod +x synology-setup.sh
./synology-setup.sh

# Check if Docker is running
docker --version
docker-compose --version
```

## STEP 4: Configure Environment

```bash
# Copy environment file
cp .env.production .env

# Edit .env file
nano .env
```

### Required .env Changes:
```bash
# Update these values in .env
APP_URL=http://[SYNOLOGY-IP]:8080
DB_HOST=mysql
DB_DATABASE=erp_db
DB_USERNAME=erp_user  
DB_PASSWORD=YourSecurePassword123

# Generate app key
APP_KEY=base64:your-generated-key-here

# Passport keys (will generate later)
PASSPORT_PRIVATE_KEY=""
PASSPORT_PUBLIC_KEY=""
```
