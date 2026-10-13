# Ultimate ERP - Deployment Guide untuk Synology NAS & Mobile App

## 📋 Prerequisites

### Synology NAS Requirements:
- **Model**: DS1821+ atau yang kompatibel
- **DSM Version**: 7.0 atau lebih baru
- **RAM**: Minimum 8GB (16GB recommended)
- **Storage**: Minimum 100GB free space
- **Packages**: Docker, Web Station, File Station

### System Requirements:
- **PHP**: 8.1 atau 8.2
- **MySQL/MariaDB**: 8.0+
- **Redis**: 7.0+
- **Nginx**: 1.20+

## 🚀 Deployment Steps

### 1. Persiapan Synology NAS

```bash
# 1. Install Docker package dari Package Center
# 2. Enable SSH di Control Panel > Terminal & SNMP
# 3. Create shared folders:
mkdir -p /volume1/docker/erp-mysql
mkdir -p /volume1/docker/erp-redis
mkdir -p /volume1/backup/erp
```

### 2. Setup SSL Certificate

```bash
# Via DSM Control Panel > Security > Certificate
# Atau menggunakan Let's Encrypt:
# Control Panel > Security > Certificate > Add > Get a certificate from Let's Encrypt
```

### 3. Deploy dengan Docker Compose

```bash
# Upload project ke Synology
scp -r erp-project admin@synology-ip:/volume1/docker/

# SSH ke Synology
ssh admin@synology-ip

# Navigate to project directory
cd /volume1/docker/erp-project

# Copy production environment
cp .env.production .env

# Update .env dengan konfigurasi yang sesuai
nano .env

# Deploy
docker-compose up -d

# Check status
docker-compose ps
```

### 4. Initial Setup

```bash
# Enter container
docker-compose exec app bash

# Run migrations
php artisan migrate --force

# Install passport
php artisan passport:install

# Create admin user
php artisan tinker
>>> User::factory()->create(['username' => 'admin', 'password' => Hash::make('password')])

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. Configure Nginx Reverse Proxy

```bash
# Copy SSL certificates to docker/ssl/
cp /usr/local/etc/certificate/WebStation/your-domain.com/* docker/ssl/

# Update nginx-proxy.conf dengan domain Anda
# Restart proxy
docker-compose restart nginx-proxy
```

## 📱 Mobile App Configuration

### API Endpoints Base URL:
```
Production: https://your-domain.com/api/v1
Development: http://localhost:8080/api/v1
```

### Authentication Flow:
1. **Login**: `POST /auth/login`
2. **Register**: `POST /auth/register`
3. **Refresh Token**: `POST /auth/refresh`
4. **Logout**: `POST /auth/logout`

### Key Features Available via API:
- ✅ Dashboard & Analytics
- ✅ Product Management
- ✅ POS Sales
- ✅ Inventory Management
- ✅ Customer Management
- ✅ Reports & Export
- ✅ Barcode Scanning
- ✅ Offline Sync
- ✅ Push Notifications

## 🔧 Configuration

### Environment Variables (.env):
```bash
# Update these values
APP_URL=https://your-domain.com
DB_HOST=mysql
DB_DATABASE=erp_db
DB_USERNAME=erp_user
DB_PASSWORD=your-secure-password

# Passport keys (generate with: php artisan passport:keys)
PASSPORT_PRIVATE_KEY="..."
PASSPORT_PUBLIC_KEY="..."

# Mobile app settings
FCM_SERVER_KEY=your-fcm-key
MOBILE_API_VERSION=1.0.0
```

### Nginx Configuration:
- Rate limiting: 60 req/min untuk API
- SSL/TLS termination
- CORS headers untuk mobile app
- Static file caching
- Gzip compression

### Database Configuration:
- MySQL 8.0 dengan persistent volumes
- Automated daily backups
- Transaction isolation level: READ-COMMITTED
- Character set: utf8mb4_unicode_ci

### Redis Configuration:
- Session storage
- Cache backend
- Queue backend
- Real-time notifications

## 📊 Monitoring & Maintenance

### Health Checks:
```bash
# Application health
curl https://your-domain.com/health

# Database connectivity
docker-compose exec app php artisan tinker
>>> DB::connection()->getPdo()

# Redis connectivity
docker-compose exec redis redis-cli ping
```

### Automated Backups:
```bash
# Backup script runs daily at 2 AM
# Location: /volume1/backup/erp/
# Retention: 30 days

# Manual backup
docker-compose exec backup /backup.sh
```

### Log Monitoring:
```bash
# Application logs
docker-compose logs -f app

# Nginx logs
docker-compose logs -f nginx-proxy

# Database logs
docker-compose logs -f mysql
```

### Performance Optimization:
```bash
# Clear caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache

# Optimize autoloader
docker-compose exec app composer install --optimize-autoloader --no-dev

# Database optimization
docker-compose exec mysql mysql -u root -p -e "OPTIMIZE TABLE database_name.*"
```

## 🔒 Security Considerations

### SSL/TLS:
- ✅ Force HTTPS redirect
- ✅ Strong cipher suites
- ✅ HSTS headers
- ✅ Certificate auto-renewal

### API Security:
- ✅ OAuth 2.0 with Passport
- ✅ Rate limiting
- ✅ CORS configuration
- ✅ Input validation
- ✅ SQL injection protection

### System Security:
- ✅ Regular security updates
- ✅ Firewall configuration
- ✅ Access logging
- ✅ Failed login monitoring

## 📱 Mobile App Development

### Recommended Tech Stack:
- **Framework**: Flutter atau React Native
- **State Management**: Provider/Redux
- **HTTP Client**: Dio/Axios
- **Local Storage**: SQLite/Hive
- **Barcode**: ML Kit/ZXing
- **Push Notifications**: FCM

### Key Features to Implement:
1. **Offline Mode**: SQLite local database
2. **Sync Mechanism**: Background sync when online
3. **Barcode Scanner**: Product search & stock update
4. **POS Interface**: Touch-friendly sales interface
5. **Reports**: Export to PDF/Excel
6. **Push Notifications**: Stock alerts, sales notifications

### API Integration Examples:
```dart
// Flutter example
class ApiService {
  static const String baseUrl = 'https://your-domain.com/api/v1';
  
  Future<Map<String, dynamic>> login(String username, String password) async {
    final response = await dio.post('$baseUrl/auth/login', data: {
      'username': username,
      'password': password,
    });
    return response.data;
  }
}
```

## 🚨 Troubleshooting

### Common Issues:

1. **Container won't start**:
   ```bash
   docker-compose logs app
   # Check .env configuration
   # Verify database connectivity
   ```

2. **API returns 500 error**:
   ```bash
   docker-compose exec app php artisan log:tail
   # Check storage permissions
   # Verify database migrations
   ```

3. **Mobile app can't connect**:
   - Verify CORS configuration
   - Check SSL certificate
   - Test API endpoints manually

### Support:
- **Documentation**: `/docs` endpoint
- **API Documentation**: `/api/documentation` 
- **System Requirements**: Check compatibility matrix
- **Updates**: Follow semantic versioning

---

## 📞 Support & Updates

Untuk mendapatkan update terbaru dan support, hubungi tim development atau check repository untuk changelog dan release notes.

**Version**: 1.0.0  
**Last Updated**: January 2025  
**Compatibility**: Synology DSM 7.0+, Mobile iOS 12+/Android 8+
