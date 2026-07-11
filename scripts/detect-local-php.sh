#!/usr/bin/env bash
# Detect PHP/Composer/Node from your Mac — reuses the same stack as your other projects.
# Sources: PATH, Laravel Herd, Valet, MAMP, XAMPP, Homebrew, asdf, user config.

detect_php() {
  # 1) User override (copy local.config.sh.example → local.config.sh)
  if [ -n "${OKTOBERFEST_PHP:-}" ] && [ -x "$OKTOBERFEST_PHP" ]; then
    echo "$OKTOBERFEST_PHP"; return 0
  fi
  if [ -f "${OKTOBERFEST_ROOT:-.}/local.config.sh" ]; then
    # shellcheck source=/dev/null
    source "${OKTOBERFEST_ROOT}/local.config.sh"
    if [ -n "${OKTOBERFEST_PHP:-}" ] && [ -x "$OKTOBERFEST_PHP" ]; then
      echo "$OKTOBERFEST_PHP"; return 0
    fi
  fi

  # 2) Already in PATH (same as your other projects)
  if command -v php >/dev/null 2>&1; then
    command -v php; return 0
  fi

  # 3) Common Mac PHP locations
  local candidates=()
  if [[ "$OSTYPE" == "darwin"* ]]; then
    candidates+=(
      "$HOME/Library/Application Support/Herd/bin/php"
      "/opt/homebrew/bin/php"
      "/usr/local/bin/php"
      "/Applications/MAMP/bin/php/php8.3.*/bin/php"
      "/Applications/MAMP/bin/php/php8.2.*/bin/php"
      "/Applications/XAMPP/xamppfiles/bin/php"
      "$HOME/.asdf/shims/php"
    )
    # MAMP versioned folders
    for mamp in /Applications/MAMP/bin/php/php*/bin/php; do
      [ -x "$mamp" ] && candidates+=("$mamp")
    done
  fi

  for bin in "${candidates[@]}"; do
    if [ -x "$bin" ] 2>/dev/null; then
      echo "$bin"; return 0
    fi
  done

  return 1
}

detect_composer() {
  if [ -n "${OKTOBERFEST_COMPOSER:-}" ] && [ -x "${OKTOBERFEST_COMPOSER%% *}" ] 2>/dev/null; then
    echo "$OKTOBERFEST_COMPOSER"; return 0
  fi

  if command -v composer >/dev/null 2>&1; then
    echo "composer"; return 0
  fi

  local php_bin
  php_bin="$(detect_php)" || return 1

  if [ -f "${OKTOBERFEST_ROOT:-.}/composer" ]; then
    echo "$php_bin ${OKTOBERFEST_ROOT}/composer"; return 0
  fi

  if [ -f "$HOME/.composer/composer.phar" ]; then
    echo "$php_bin $HOME/.composer/composer.phar"; return 0
  fi

  if [ -f "/usr/local/bin/composer" ]; then
    echo "/usr/local/bin/composer"; return 0
  fi

  return 1
}

detect_node() {
  if [ -n "${OKTOBERFEST_NODE:-}" ] && [ -x "$OKTOBERFEST_NODE" ]; then
    echo "$OKTOBERFEST_NODE"; return 0
  fi
  if command -v node >/dev/null 2>&1; then
    command -v node; return 0
  fi
  if [ -x "/opt/homebrew/bin/node" ]; then echo "/opt/homebrew/bin/node"; return 0; fi
  if [ -x "/usr/local/bin/node" ]; then echo "/usr/local/bin/node"; return 0; fi
  return 1
}

setup_local_tools() {
  OKTOBERFEST_ROOT="${OKTOBERFEST_ROOT:-$(cd "$(dirname "${BASH_SOURCE[1]:-${BASH_SOURCE[0]}}")/.." && pwd)}"

  PHP_BIN="$(detect_php)" || {
    echo "❌ PHP not found. Set OKTOBERFEST_PHP in local.config.sh"
    echo "   Example: export OKTOBERFEST_PHP=/Applications/MAMP/bin/php/php8.3.14/bin/php"
    return 1
  }

  COMPOSER_CMD="$(detect_composer)" || {
    echo "❌ Composer not found. Install it or set OKTOBERFEST_COMPOSER in local.config.sh"
    return 1
  }

  NODE_BIN="$(detect_node)" || NODE_BIN=""

  export PHP_BIN COMPOSER_CMD NODE_BIN
  export PATH="$(dirname "$PHP_BIN"):$PATH"

  echo "→ Using PHP:     $PHP_BIN ($("$PHP_BIN" -v | head -1))"
  echo "→ Using Composer: $COMPOSER_CMD"
  [ -n "$NODE_BIN" ] && echo "→ Using Node:    $NODE_BIN ($("$NODE_BIN" -v 2>/dev/null))"
}
