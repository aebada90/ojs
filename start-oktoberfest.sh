#!/usr/bin/env bash
# Oktoberfest AI — uses YOUR existing PHP/Composer from other projects on this Mac
set -e

ROOT="$(cd "$(dirname "$0")" && pwd)"
OKTOBERFEST_ROOT="$ROOT"
export OKTOBERFEST_ROOT

# shellcheck source=scripts/detect-local-php.sh
source "$ROOT/scripts/detect-local-php.sh"
setup_local_tools

cd "$ROOT/platform"

PORT="${OKTOBERFEST_PORT:-8888}"
HOST="${OKTOBERFEST_HOST:-127.0.0.1}"

echo ""
echo "🍺 Oktoberfest AI — Local Server"
echo "================================"

# First-time setup
if [ ! -f .env ]; then
  echo "→ Creating .env (SQLite — no MySQL needed locally)..."
  cp .env.example .env
  # Use SQLite for local dev like a simple PHP project
  if grep -q "^DB_CONNECTION=mysql" .env; then
    sed -i.bak 's/^DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env 2>/dev/null || \
      sed -i '' 's/^DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
  fi
  touch database/database.sqlite 2>/dev/null || true
  $PHP_BIN artisan key:generate --force
fi

if [ ! -d vendor ]; then
  echo "→ Installing PHP packages..."
  $COMPOSER_CMD install --no-interaction
fi

if [ ! -f public/build/manifest.json ] && [ -n "$NODE_BIN" ]; then
  echo "→ Building frontend..."
  (cd "$ROOT/platform" && npm install --silent && npm run build --silent) || true
fi

if [ ! -f database/database.sqlite ]; then
  touch database/database.sqlite
fi

echo "→ Database..."
$PHP_BIN artisan migrate --force --seed 2>/dev/null || $PHP_BIN artisan migrate --force

if grep -q "^APP_URL=" .env; then
  sed -i.bak "s|^APP_URL=.*|APP_URL=http://127.0.0.1:${PORT}|" .env 2>/dev/null || \
    sed -i '' "s|^APP_URL=.*|APP_URL=http://127.0.0.1:${PORT}|" .env
fi

$PHP_BIN artisan config:clear --quiet 2>/dev/null || true

echo ""
echo "✅ Ready!  http://127.0.0.1:${PORT}"
echo "   Login: admin@oktoberfest.ai / password"
echo "   Ctrl+C to stop"
echo "================================"
echo ""

$PHP_BIN artisan serve --host="$HOST" --port="$PORT"
