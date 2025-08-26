# 🚀 Deployment Guide - NHIA Claims Manager

## Free Hosting Options

### 1. Railway (Recommended - $5/month credit)
1. Go to [railway.app](https://railway.app)
2. Sign up with GitHub
3. Click "New Project" → "Deploy from GitHub repo"
4. Select your repository: `1Kwadwo/-nhia-claims-manager`
5. Railway will automatically detect Laravel and deploy

### 2. Render (Free tier available)
1. Go to [render.com](https://render.com)
2. Sign up with GitHub
3. Click "New" → "Web Service"
4. Connect your GitHub repository
5. Configure:
   - **Build Command:** `composer install && php artisan key:generate && php artisan migrate --seed`
   - **Start Command:** `php artisan serve --host=0.0.0.0 --port=$PORT`

### 3. Heroku ($5/month - no free tier)
1. Go to [heroku.com](https://heroku.com)
2. Create account and verify with credit card
3. Install Heroku CLI
4. Run:
   ```bash
   heroku create your-app-name
   git push heroku main
   heroku run php artisan migrate --seed
   ```

## Environment Variables to Set

Set these in your hosting platform's environment variables:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-url.com
APP_KEY=base64:your-generated-key

DB_CONNECTION=sqlite
DB_DATABASE=/tmp/database.sqlite

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

## Database Options

### For Free Hosting:
- **SQLite** (recommended for free tiers)
- **PostgreSQL** (Railway/Render provide free PostgreSQL)

### For Production:
- **MySQL** or **PostgreSQL** on managed services

## Quick Deploy Commands

After setting up your hosting platform:

```bash
# Generate application key
php artisan key:generate

# Run migrations and seed data
php artisan migrate --seed

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Custom Domain Setup

Most platforms allow custom domains:
1. Add your domain in the hosting platform
2. Update DNS records to point to the platform
3. Update `APP_URL` in environment variables
