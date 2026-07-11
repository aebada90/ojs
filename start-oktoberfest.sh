#!/usr/bin/env bash
# Oktoberfest AI — local dev server (NOT the OJS app in repo root)
set -e

ROOT="$(cd "$(dirname "$0")" && pwd)"
cd "$ROOT/platform"

PORT="${OKTOBERFEST_PORT:-8888}"
HOST="${OKTOBERFEST_HOST:-0.0.0.0}"

echo "🍺 Oktoberfest AI — Local Setup"
echo "================================"

# PHP check
if ! command -v php >/dev/null 2>&1; then
  echo "❌ PHP not found. Install PHP 8.3+ first."
  exit 1
fi

# Composer check
COMPOSER="composer"
if ! command -v composer >/dev/null 2>&1; then
  if [ -f "$ROOT/composer" ]; then
    COMPOSER="php $ROOT/composer"
  else
    echo "❌ Composer not found. Run: curl -sS https://getcomposer.org/installer | php"
    exit 1
  fi
fi

# First-time setup
if [ ! -f .env ]; then
  echo "→ Creating .env..."
  cp .env.example .env
  php artisan key:generate --force
fi

if [ ! -d vendor ]; then
  echo "→ Installing PHP dependencies..."
  $COMPOSER install --no-interaction
fi

if [ ! -f public/build/manifest.json ]; then
  echo "→ Building frontend assets..."
  if command -v npm >/dev/null 2>&1; then
    npm install --silent
    npm run build
  else
    echo "⚠️  npm not found — skipping asset build"
  fi
fi

echo "→ Running migrations..."
php artisan migrate --force --seed 2>/dev/null || php artisan migrate --force

# Ensure APP_URL is localhost
if grep -q "^APP_URL=" .env; then
  sed -i "s|^APP_URL=.*|APP_URL=http://127.0.0.1:${PORT}|" .env
else
  echo "APP_URL=http://127.0.0.1:${PORT}" >> .env
fi

php artisan config:clear --quiet 2>/dev/null || true

echo ""
echo "✅ Ready!"
echo ""
echo "   Open in browser:  http://127.0.0.1:${PORT}"
echo "   (or http://localhost:${PORT})"
echo ""
echo "   Demo login: admin@oktoberfest.ai / password"
echo ""
echo "   Press Ctrl+C to stop"
echo "================================"
echo ""

php artisan serve --host="$HOST" --port="$PORT"
