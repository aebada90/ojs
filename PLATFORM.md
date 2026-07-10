# Oktoberfest AI Platform

This repository contains the **Oktoberfest AI / EventOS / TourismOS** platform scaffold.

The Laravel application lives in the [`platform/`](platform/) directory.

## Getting Started

```bash
cd platform
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

See [platform/README.md](platform/README.md) for full architecture, Hostinger deployment, and module documentation.

> **Note:** The repository root also contains the legacy OJS codebase. The new platform is self-contained under `platform/`.
