#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
HOST="${FTP_HOST:-92.113.19.130}"
USER="${FTP_USER:-u234903558.oktoberhub}"
PASS="${FTP_PASSWORD:-}"
PORT="${FTP_PORT:-21}"

if [[ -z "$PASS" && -f "$ROOT/.ftp.env" ]]; then
  # shellcheck disable=SC1091
  source "$ROOT/.ftp.env"
  PASS="${FTP_PASSWORD:-}"
  HOST="${FTP_HOST:-$HOST}"
  USER="${FTP_USER:-$USER}"
fi

if [[ -z "$PASS" ]]; then
  echo "FTP_PASSWORD required (.ftp.env or env)"
  exit 1
fi

upload() {
  local localf="$1" remote="$2"
  local attempt
  for attempt in 1 2 3 4 5 6 7 8; do
    if curl -sS --connect-timeout 25 --max-time 120 --ftp-pasv --disable-epsv \
      -u "${USER}:${PASS}" \
      --ftp-create-dirs \
      -T "$localf" "ftp://${HOST}:${PORT}/${remote}"; then
      echo "OK ${remote}"
      return 0
    fi
    echo "retry ${attempt} ${remote}"
    sleep $((attempt * 3))
  done
  echo "FAIL ${remote}"
  return 1
}

mapfile -t FILES <<EOF
app/Http/Controllers/PartnerController.php|laravel/app/Http/Controllers/PartnerController.php
app/Http/Controllers/MatchmakingController.php|laravel/app/Http/Controllers/MatchmakingController.php
app/Http/Controllers/MatchmakingGroupController.php|laravel/app/Http/Controllers/MatchmakingGroupController.php
app/Models/MatchmakingProfile.php|laravel/app/Models/MatchmakingProfile.php
app/Models/MatchmakingConnection.php|laravel/app/Models/MatchmakingConnection.php
app/Models/MatchmakingGroup.php|laravel/app/Models/MatchmakingGroup.php
app/Models/MatchmakingGroupMember.php|laravel/app/Models/MatchmakingGroupMember.php
app/Support/ConnectDemoProfiles.php|laravel/app/Support/ConnectDemoProfiles.php
config/connect.php|laravel/config/connect.php
lang/en/platform.php|laravel/lang/en/platform.php
lang/de/platform.php|laravel/lang/de/platform.php
resources/views/partners/connect.blade.php|laravel/resources/views/partners/connect.blade.php
resources/views/partners/dating.blade.php|laravel/resources/views/partners/dating.blade.php
resources/views/matchmaking/index.blade.php|laravel/resources/views/matchmaking/index.blade.php
resources/views/matchmaking/people.blade.php|laravel/resources/views/matchmaking/people.blade.php
resources/views/matchmaking/show.blade.php|laravel/resources/views/matchmaking/show.blade.php
resources/views/matchmaking/profile-edit.blade.php|laravel/resources/views/matchmaking/profile-edit.blade.php
resources/views/matchmaking/connections.blade.php|laravel/resources/views/matchmaking/connections.blade.php
resources/views/matchmaking/groups/index.blade.php|laravel/resources/views/matchmaking/groups/index.blade.php
resources/views/matchmaking/groups/create.blade.php|laravel/resources/views/matchmaking/groups/create.blade.php
resources/views/matchmaking/groups/show.blade.php|laravel/resources/views/matchmaking/groups/show.blade.php
database/migrations/2026_10_02_120000_create_matchmaking_tables.php|laravel/database/migrations/2026_10_02_120000_create_matchmaking_tables.php
EOF

fail=0
for row in "${FILES[@]}"; do
  localf="${ROOT}/${row%%|*}"
  remote="${row##*|}"
  upload "$localf" "$remote" || fail=1
done

exit "$fail"
