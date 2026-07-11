#!/usr/bin/env bash
# One-command Oktoberfest AI setup for Mac — run from ANY folder:
#   bash -c "$(curl -fsSL https://raw.githubusercontent.com/aebada90/ojs/cursor/oktoberfest-platform-fea0/setup-mac.sh)"
set -e

INSTALL_DIR="${OKTOBERFEST_DIR:-$HOME/oktoberfest-ai}"
REPO="https://github.com/aebada90/ojs.git"
BRANCH="cursor/oktoberfest-platform-fea0"
PORT=8888

echo ""
echo "🍺 Oktoberfest AI — Automatic Setup"
echo "===================================="

# --- Homebrew deps (Mac) ---
if [[ "$OSTYPE" == "darwin"* ]]; then
  if ! command -v brew >/dev/null 2>&1; then
    echo "→ Installing Homebrew..."
    /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
  fi
  for pkg in php composer node; do
    if ! command -v "$pkg" >/dev/null 2>&1; then
      echo "→ Installing $pkg..."
      brew install "$pkg"
    fi
  done
fi

# --- Clone or update repo ---
if [ ! -d "$INSTALL_DIR/.git" ]; then
  echo "→ Cloning project to $INSTALL_DIR ..."
  git clone --branch "$BRANCH" --single-branch "$REPO" "$INSTALL_DIR"
else
  echo "→ Updating project..."
  cd "$INSTALL_DIR"
  git fetch origin "$BRANCH" 2>/dev/null || true
  git checkout "$BRANCH" 2>/dev/null || true
  git pull origin "$BRANCH" 2>/dev/null || true
fi

cd "$INSTALL_DIR/platform"

# --- PHP setup ---
if [ ! -f .env ]; then
  echo "→ Creating .env..."
  cp .env.example .env
  php artisan key:generate --force
fi

if [ ! -d vendor ]; then
  echo "→ Installing PHP packages (may take 1-2 min)..."
  composer install --no-interaction --quiet
fi

if [ ! -f public/build/manifest.json ]; then
  echo "→ Building frontend..."
  npm install --silent 2>/dev/null
  npm run build --silent 2>/dev/null
fi

echo "→ Database setup..."
php artisan migrate --force --seed 2>/dev/null || php artisan migrate --force

sed -i.bak "s|^APP_URL=.*|APP_URL=http://127.0.0.1:${PORT}|" .env 2>/dev/null || \
  sed -i '' "s|^APP_URL=.*|APP_URL=http://127.0.0.1:${PORT}|" .env
php artisan config:clear --quiet 2>/dev/null || true

echo ""
echo "===================================="
echo "✅ Oktoberfest AI is READY!"
echo ""
echo "   🌐 Open:  http://127.0.0.1:${PORT}"
echo "   👤 Login: admin@oktoberfest.ai / password"
echo ""
echo "   Keep this window open. Press Ctrl+C to stop."
echo "===================================="
echo ""

cd "$INSTALL_DIR"
exec ./start-oktoberfest.sh
