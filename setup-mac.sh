#!/usr/bin/env bash
# One-command setup — uses the SAME PHP/Composer already on your Mac (Herd, MAMP, Homebrew, etc.)
#   bash -c "$(curl -fsSL https://raw.githubusercontent.com/aebada90/ojs/cursor/oktoberfest-platform-fea0/setup-mac.sh)"
set -e

INSTALL_DIR="${OKTOBERFEST_DIR:-$HOME/oktoberfest-ai}"
REPO="https://github.com/aebada90/ojs.git"
BRANCH="cursor/oktoberfest-platform-fea0"

echo ""
echo "🍺 Oktoberfest AI — Setup (reusing your Mac PHP)"
echo "================================================="

# --- Clone or update ---
if [ ! -d "$INSTALL_DIR/.git" ]; then
  echo "→ Cloning to $INSTALL_DIR ..."
  git clone --branch "$BRANCH" --single-branch "$REPO" "$INSTALL_DIR"
else
  echo "→ Updating $INSTALL_DIR ..."
  cd "$INSTALL_DIR"
  git fetch origin "$BRANCH" 2>/dev/null || true
  git checkout "$BRANCH" 2>/dev/null || true
  git pull origin "$BRANCH" 2>/dev/null || true
fi

cd "$INSTALL_DIR"

# Copy local config example if user has no config yet
if [ ! -f local.config.sh ] && [ -f local.config.sh.example ]; then
  cp local.config.sh.example local.config.sh
  echo "→ Created local.config.sh — edit it if PHP is not auto-detected"
fi

# --- Run start script (detects PHP, no Homebrew install) ---
exec ./start-oktoberfest.sh
