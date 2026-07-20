#!/usr/bin/env bash
# Oktoberfest AI — same local setup as ai-journal (standard Laravel)
set -e

cd "$(dirname "$0")/platform"

echo ""
echo "🍺 Oktoberfest AI — Local Server"
echo "================================"

if [ ! -f .env ]; then
  echo "→ First-time setup (composer run setup)..."
  composer run setup
else
  if [ ! -d vendor ]; then
    composer install --no-interaction
  fi
  if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
  fi
  php artisan migrate --force --seed
  if [ ! -f public/build/manifest.json ]; then
    npm install --ignore-scripts && npm run build
  fi
fi

echo ""
echo "✅ Ready!  http://localhost:8000"
echo "   Login: admin@oktoberfest.ai / password"
echo "   Ctrl+C to stop"
echo "================================"
echo ""

php artisan serve
