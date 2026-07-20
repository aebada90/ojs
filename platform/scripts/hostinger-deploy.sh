#!/usr/bin/env bash
# Deploy Oktoberfest platform to Hostinger (oktoberhub.de)
#
# Usage on the Hostinger server (SSH):
#   cd ~/domains/oktoberhub.de/public_html   # or your app root
#   bash -c "$(curl -fsSL https://raw.githubusercontent.com/aebada90/ojs/cursor/oktoberfest-platform-fea0/platform/scripts/hostinger-deploy.sh)"
#
# Or from this machine (requires SSH access):
#   HOSTINGER_SSH="u123@oktoberhub.de" HOSTINGER_SSH_PORT=65002 ./platform/scripts/hostinger-deploy.sh remote
set -euo pipefail

DOMAIN="${HOSTINGER_DOMAIN:-oktoberhub.de}"
BRANCH="${HOSTINGER_BRANCH:-cursor/oktoberfest-platform-fea0}"
REPO="${HOSTINGER_REPO:-https://github.com/aebada90/ojs.git}"

remote_deploy() {
  local ssh_target="${HOSTINGER_SSH:?Set HOSTINGER_SSH e.g. u123456789@oktoberhub.de}"
  local port="${HOSTINGER_SSH_PORT:-65002}"
  local remote_path="${HOSTINGER_PATH:-domains/${DOMAIN}/public_html}"

  echo "==> Deploying ${BRANCH} to ${ssh_target}:${remote_path}"
  ssh -p "$port" -o StrictHostKeyChecking=accept-new "$ssh_target" bash -s <<EOF
set -euo pipefail
cd ~/${remote_path}

if [ -d .git ]; then
  git fetch origin ${BRANCH}
  git checkout ${BRANCH}
  git pull origin ${BRANCH}
elif [ -d platform/.git ]; then
  cd platform
  git fetch origin ${BRANCH}
  git checkout ${BRANCH}
  git pull origin ${BRANCH}
else
  echo "No git repo found. Clone once:"
  echo "  git clone --branch ${BRANCH} ${REPO} ."
  exit 1
fi

# App may live in platform/ or at document root
if [ -f artisan ]; then
  APP_DIR="."
elif [ -f platform/artisan ]; then
  APP_DIR="platform"
else
  echo "Laravel artisan not found"; exit 1
fi

cd "\$APP_DIR"
composer install --optimize-autoloader --no-dev --no-interaction

if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate --force
  echo "⚠️  Configure .env MySQL + mail, then re-run."
fi

# Ensure live mail + URL
php -r '
\$env = file_get_contents(".env");
\$vars = [
  "APP_URL" => "https://${DOMAIN}",
  "MAIL_MAILER" => "smtp",
  "MAIL_HOST" => "smtp.hostinger.com",
  "MAIL_PORT" => "587",
  "MAIL_USERNAME" => "info@${DOMAIN}",
  "MAIL_FROM_ADDRESS" => "info@${DOMAIN}",
  "MAIL_ENCRYPTION" => "tls",
  "VERIFY_EMAIL_INLINE" => "true",
];
foreach (\$vars as \$k => \$v) {
  if (preg_match("/^{\$k}=.*/m", \$env)) {
    \$env = preg_replace("/^{\$k}=.*/m", "{\$k}={\$v}", \$env);
  } else {
    \$env .= "\n{\$k}={\$v}\n";
  }
}
file_put_contents(".env", \$env);
'

php artisan migrate --force
php artisan storage:link 2>/dev/null || true
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "✅ Live deploy complete → https://${DOMAIN}"
EOF
}

local_on_server() {
  echo "==> Running deploy on this Hostinger account"

  if [ -f artisan ]; then
    APP_DIR="."
  elif [ -f platform/artisan ]; then
    APP_DIR="platform"
  elif [ -d ~/domains/${DOMAIN}/public_html/platform ]; then
    APP_DIR=~/domains/${DOMAIN}/public_html/platform
  elif [ -d ~/public_html/platform ]; then
    APP_DIR=~/public_html/platform
  else
    echo "Cannot find Laravel app. cd into the platform folder and re-run."
    exit 1
  fi

  cd "$APP_DIR"
  echo "→ App: $(pwd)"

  if [ -d ../.git ] || [ -d .git ]; then
    ROOT="$(git rev-parse --show-toplevel)"
    cd "$ROOT"
    git fetch origin "$BRANCH" || true
    git checkout "$BRANCH" || true
    git pull origin "$BRANCH" || true
    cd "$APP_DIR"
  fi

  composer install --optimize-autoloader --no-dev --no-interaction

  if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate --force
  fi

  php artisan migrate --force
  php artisan storage:link 2>/dev/null || true
  php artisan optimize:clear
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache

  echo ""
  echo "✅ Live deploy complete → https://${DOMAIN}"
  echo "Cron (hPanel): * * * * * cd $(pwd) && php artisan schedule:run >> /dev/null 2>&1"
}

MODE="${1:-local}"
case "$MODE" in
  remote) remote_deploy ;;
  local|*) local_on_server ;;
esac
