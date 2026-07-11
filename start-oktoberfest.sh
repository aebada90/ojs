#!/usr/bin/env bash
# Start the Oktoberfest AI website (NOT the OJS project in repo root)
cd "$(dirname "$0")/platform" || exit 1

echo "Starting Oktoberfest AI website..."
echo "Open: http://127.0.0.1:8888"
echo ""

php artisan serve --host=127.0.0.1 --port=8888
