# Quick Start Guide

## Installation (One-time setup)

```bash
cd /Users/moses/Desktop/freelance/job_search/vue-starter-kit

# Install PHP & Node dependencies
composer install
npm install

# Setup environment files
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed  # Seeds AdminUserSeeder for testing notifications

# Build frontend assets
npm run build
```

## Running the Application

### Terminal 1: Start Laravel Server
```bash
php artisan serve
# Server runs at http://localhost:8000
```

### Terminal 2: Process Queue Jobs
```bash
php artisan queue:work
# Keep this running in background to process notifications
```

### Terminal 3 (Optional): Run Scheduler
```bash
php artisan schedule:work
# Runs every minute in development to test scheduled tasks
```

### Terminal 4 (Optional): Watch Frontend Changes
```bash
npm run dev
# Auto-rebuilds Vue components as you edit them
```

---

## Testing

```bash
# Run all tests (46 tests should pass)
php artisan test --testdox

# Run specific test
php artisan test tests/Feature/CartTest.php

# Run with coverage report
php artisan test --coverage
```

---

## Testing Features

### 1. Test Low Stock Notification

```bash
# Start queue worker first (Terminal 2)
php artisan queue:work

# In Terminal 1, open artisan tinker
php artisan tinker

# Run these commands:
$product = App\Models\Product::first();
$product->update(['stock_quantity' => 5]);  # Triggers notification
exit

# Check email log:
tail -f storage/logs/laravel.log | grep -i mail
```

### 2. Test Daily Sales Report

```bash
# Run command manually
php artisan sales:daily-report

# Output: Email sent to admin@example.com
# Check logs: tail -f storage/logs/laravel.log
```

### 3. Test Checkout Flow

1. Visit http://localhost:8000
2. Register a new account
3. Navigate to "Products"
4. Add items to cart
5. Go to cart and click "Checkout"
6. See order confirmation page
7. Check database: `SELECT * FROM orders;`

---

## Database Reset

```bash
# Wipe everything and reseed
php artisan migrate:fresh --seed

# Just run seeder
php artisan db:seed
```

---

## Key Credentials

**Admin User** (created by seeder):
- Email: `admin@example.com`
- Password: `password` (or set during registration)

**Test User** (any registered user):
- Can add items to cart
- Can checkout
- Can view orders

---

## File Locations

| Feature | Files |
|---------|-------|
| Products Page | `resources/js/pages/Products/Index.vue` |
| Cart Page | `resources/js/pages/Cart/Index.vue` |
| Order Confirmation | `resources/js/pages/Orders/Show.vue` |
| Cart Logic | `app/Http/Controllers/CartController.php` |
| Order Logic | `app/Http/Controllers/OrderController.php` |
| Notifications | `app/Jobs/LowStockNotification.php`, `app/Observers/ProductObserver.php` |
| Daily Report | `app/Console/Commands/SendDailySalesReportCommand.php` |
| Tests | `tests/Feature/*.php` |

---

## Troubleshooting

### Queue not processing jobs?
```bash
# Make sure queue worker is running
php artisan queue:work
```

### Tests failing?
```bash
# Make sure test database is configured
# Check .env.testing file exists
php artisan test --testdox
```

### Products not showing?
```bash
# Make sure seeder ran
php artisan db:seed --class=ProductSeeder
```

### Notifications not sending?
```bash
# Check mail configuration in config/mail.php
# Default is 'log' driver - emails logged to storage/logs/laravel.log
```

---

## Email Configuration

Currently uses **log driver** (emails logged to console/file).

To send real emails, update `.env`:
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@example.com
```

---

## Production Deployment

```bash
# Build optimized assets
npm run build

# Install production dependencies only
composer install --no-dev

# Set production environment
cp .env.production .env

# Run migrations on production database
php artisan migrate --force

# Cache configuration
php artisan config:cache

# Add to crontab (runs scheduler)
* * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1

# Start queue worker with supervisor
# (use Supervisor or similar to keep queue worker running)
```

---

## All Done! 🎉

Your e-commerce application is ready to use. All 8 milestones are complete with 46 passing tests.

For detailed documentation, see:
- `IMPLEMENTATION_COMPLETE.md` - Complete feature list
- `FINAL_VERIFICATION.md` - Test results and verification
- `PROJECT_MILESTONES.md` - Original requirements
