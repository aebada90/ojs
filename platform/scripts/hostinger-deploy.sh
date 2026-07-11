#!/usr/bin/env bash
# Run this ON Hostinger via SSH after uploading the platform/ folder
set -e

cd ~/domains/YOUR_DOMAIN/public_html/platform || cd ~/public_html/platform

echo "==> Installing dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

echo "==> Environment..."
if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate
  echo "⚠️  Edit .env with your MySQL credentials from hPanel"
fi

echo "==> Database..."
php artisan migrate --force --seed

echo "==> Storage link..."
php artisan storage:link 2>/dev/null || true

echo "==> Cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "✅ Oktoberfest AI is ready!"
echo "Point your domain document root to: public_html/platform/public"
echo "Add cron: * * * * * cd ~/public_html/platform && php artisan schedule:run"
