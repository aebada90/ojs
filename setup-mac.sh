#!/usr/bin/env bash
# One-command clone + setup — same flow as ai-journal
#   bash -c "$(curl -fsSL https://raw.githubusercontent.com/aebada90/ojs/cursor/oktoberfest-platform-fea0/setup-mac.sh)"
set -e

INSTALL_DIR="${OKTOBERFEST_DIR:-$HOME/oktoberfest-ai}"
REPO="https://github.com/aebada90/ojs.git"
BRANCH="cursor/oktoberfest-platform-fea0"

echo ""
echo "🍺 Oktoberfest AI — Setup"
echo "========================="

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
exec ./start-oktoberfest.sh
