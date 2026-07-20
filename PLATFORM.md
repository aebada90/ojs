# Oktoberfest AI Platform

This repository contains the **Oktoberfest AI / EventOS / TourismOS** platform scaffold.

The Laravel application lives in the [`platform/`](platform/) directory — same setup pattern as [`ai-journal`](https://github.com/aebada90/ojs/tree/cursor/ai-journal-laravel-5b63/ai-journal) on branch `cursor/ai-journal-laravel-5b63`.

> **Important:** The repo root is the legacy **OJS** project. Run Oktoberfest from `platform/`, not the repo root.

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+
- SQLite (default) or MySQL

## Installation

```bash
cd platform
composer install
cp .env.example .env   # if needed
php artisan key:generate
touch database/database.sqlite   # if using SQLite
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

Or use the composer shortcut (same as ai-journal):

```bash
cd platform
composer run setup
php artisan serve
```

Visit **http://localhost:8000**

**Demo accounts** (after seeding):

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@oktoberfest.ai | password |
| Vendor | vendor@oktoberfest.ai | password |

## Quick start script

From the repo root:

```bash
./start-oktoberfest.sh
```

This runs the same steps above and starts the server on port 8000.

## Development (with Vite hot reload)

```bash
cd platform
composer run dev
```

See [platform/README.md](platform/README.md) for architecture, Hostinger deployment, and module documentation.
