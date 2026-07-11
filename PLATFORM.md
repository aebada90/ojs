# Oktoberfest AI Platform

This repository contains the **Oktoberfest AI / EventOS / TourismOS** platform scaffold.

The Laravel application lives in the [`platform/`](platform/) directory.

> **Important:** The repo root is the legacy **OJS** project.  
> If you open `localhost:8000` from the repo root, you will see OJS — **not** Oktoberfest.

## Getting Started (Oktoberfest website)

```bash
# Option 1 — use the start script (recommended)
./start-oktoberfest.sh
# Then open: http://127.0.0.1:8888

# Option 2 — manual
cd platform
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
php artisan serve --host=127.0.0.1 --port=8888
```

**Oktoberfest website URL:** http://127.0.0.1:8888

See [platform/README.md](platform/README.md) for full architecture, Hostinger deployment, and module documentation.

> **Note:** The repository root also contains the legacy OJS codebase. The new platform is self-contained under `platform/`.
