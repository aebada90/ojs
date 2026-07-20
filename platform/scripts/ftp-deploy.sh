#!/usr/bin/env bash
# Deploy platform/ to Hostinger via FTP
#
# 1) Copy platform/.ftp.env.example → platform/.ftp.env and fill values from
#    hPanel → Websites → Dashboard → FTP Accounts
# 2) Run:  ./platform/scripts/ftp-deploy.sh
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
APP="$ROOT/platform"
ENV_FILE="${FTP_ENV_FILE:-$APP/.ftp.env}"

if [ -f "$ENV_FILE" ]; then
  # shellcheck disable=SC1090
  set -a
  source "$ENV_FILE"
  set +a
fi

FTP_HOST="${FTP_HOST:-${HOSTINGER_FTP_HOST:-}}"
FTP_USER="${FTP_USER:-${HOSTINGER_FTP_USER:-}}"
FTP_PASSWORD="${FTP_PASSWORD:-${HOSTINGER_FTP_PASSWORD:-}}"
FTP_PORT="${FTP_PORT:-${HOSTINGER_FTP_PORT:-21}}"
FTP_DIR="${FTP_DIR:-${HOSTINGER_FTP_DIR:-/public_html/platform/}}"
# Ensure trailing slash
[[ "$FTP_DIR" == */ ]] || FTP_DIR="${FTP_DIR}/"

if [ -z "$FTP_HOST" ] || [ -z "$FTP_USER" ] || [ -z "$FTP_PASSWORD" ]; then
  cat <<EOF
❌ Missing FTP credentials.

Create $APP/.ftp.env with:

  FTP_HOST=84.32.84.86
  FTP_USER=u123456789
  FTP_PASSWORD=your-ftp-password
  FTP_PORT=21
  FTP_DIR=/public_html/platform/

Get these from Hostinger hPanel → Websites → Oktoberhub → FTP Accounts
(FTP IP = host, FTP Username, change/reset FTP password if needed, port 21).
EOF
  exit 1
fi

if ! command -v lftp >/dev/null 2>&1; then
  echo "→ Installing lftp..."
  sudo apt-get update -qq && sudo apt-get install -y -qq lftp
fi

cd "$APP"

if [ ! -f public/build/manifest.json ]; then
  echo "→ Building frontend..."
  npm ci --ignore-scripts
  npm run build
fi

echo "→ Deploying $APP → ftp://$FTP_HOST:$FTP_PORT$FTP_DIR"
echo "   User: $FTP_USER"

# Mirror platform files; never upload secrets or vendor/node_modules
lftp -c "
set ftp:ssl-allow no
set ftp:passive-mode true
set net:max-retries 3
set net:timeout 20
set mirror:parallel-transfer-count 4
open -p $FTP_PORT -u \"$FTP_USER\",\"$FTP_PASSWORD\" $FTP_HOST
lcd $APP
cd $FTP_DIR || mkdir -p $FTP_DIR && cd $FTP_DIR
mirror --reverse --delete --verbose \
  --exclude-glob .env \
  --exclude-glob .env.* \
  --exclude-glob .ftp.env \
  --exclude-glob .git/ \
  --exclude-glob .git/** \
  --exclude-glob node_modules/ \
  --exclude-glob node_modules/** \
  --exclude-glob vendor/ \
  --exclude-glob vendor/** \
  --exclude-glob tests/ \
  --exclude-glob tests/** \
  --exclude-glob storage/logs/** \
  --exclude-glob storage/framework/cache/** \
  --exclude-glob storage/framework/sessions/** \
  --exclude-glob storage/framework/views/** \
  --exclude-glob .phpunit.result.cache \
  ./ ./
bye
"

echo ""
echo "✅ FTP upload complete."
echo "On Hostinger (SSH or hPanel Terminal) finish with:"
echo "  cd ~${FTP_DIR%/}"
echo "  composer install --no-dev -o"
echo "  php artisan migrate --force"
echo "  php artisan optimize:clear && php artisan config:cache && php artisan view:cache"
echo ""
echo "Live: https://oktoberhub.de"
