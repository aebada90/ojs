# Oktoberfest AI / EventOS Platform

Production-ready **Laravel 12 + PHP 8.3 + MySQL** multi-vendor tourism and festival platform optimized for **Hostinger Shared Hosting** (no VPS, Redis, Docker, Supervisor, or WebSockets).

## Stack

- Laravel 12, PHP 8.3, MySQL
- Blade, Livewire 4, Alpine.js, Tailwind CSS 4
- Laravel Fortify (auth, 2FA, email verification)
- Laravel Socialite (Google, Facebook, Apple, LinkedIn)
- Spatie Laravel Permission (roles & permissions)
- Laravel Sanctum (REST API tokens)
- Database queue, database cache, Laravel Scheduler + cron

## Architecture

Modular monolith with 23 independent modules under `modules/`:

| Module | Purpose |
|--------|---------|
| Core | Shared infrastructure |
| Auth | Social login, 2FA, roles |
| Marketplace | Multi-vendor products |
| Rental | Rent anything |
| Hotel | Accommodation booking |
| Property | Real estate marketplace |
| Restaurant | Reservations & menus |
| Vendor | Storefronts & payouts |
| Events | Ticketing |
| Payments | Stripe, PayPal, wallet |
| AI | Trip planner, SEO, support |
| Admin | Platform administration |
| CMS | Pages, blogs, media |
| Search | Universal search |
| DigitalTwin | Live map layers |
| Jobs, Experience, Services, Review, Messaging, Ecommerce, Analytics, Notifications |

Each module can be toggled in `config/modules.php`.

### Patterns

- **Repository pattern** — `app/Core/Repository/`
- **Service layer** — per-module `Services/`
- **Module providers** — `BaseModuleServiceProvider` loads routes, views, migrations
- **Policies, Form Requests, API resources** — ready per module

## Quick Start (Local)

Same setup as the **ai-journal** model project in this repo:

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

Or:

```bash
cd platform
composer run setup
php artisan serve
```

Visit **http://localhost:8000**

**Demo accounts** (after seeding):

- Admin: `admin@oktoberfest.ai` / `password`
- Vendor: `vendor@oktoberfest.ai` / `password`

## Hostinger Shared Hosting Deployment

### 1. Upload files

Upload the `platform/` contents to your hosting account (e.g. `public_html/` or a subdomain folder).

### 2. Point document root

Set the domain document root to `platform/public` (Hostinger hPanel → Domains → Document Root).

### 3. Configure environment

```bash
cp .env.example .env
# Edit .env with MySQL credentials from hPanel
php artisan key:generate
```

### 4. Install dependencies

Via SSH (if available) or locally then upload `vendor/`:

```bash
composer install --optimize-autoloader --no-dev
npm ci && npm run build
```

### 5. Run migrations

```bash
php artisan migrate --force --seed
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Cron jobs (hPanel → Advanced → Cron Jobs)

```cron
* * * * * cd /home/user/domains/your-domain.com/platform && php artisan schedule:run >> /dev/null 2>&1
```

The scheduler processes the **database queue** every minute — no Supervisor required.

### 7. Permissions

```bash
chmod -R 775 storage bootstrap/cache
```

## Module Toggle

Edit `config/modules.php`:

```php
'Marketplace' => ['enabled' => true, 'dependencies' => ['Core', 'Vendor']],
'DigitalTwin' => ['enabled' => false, 'dependencies' => ['Core', 'Search']],
```

Then run `php artisan config:clear`.

## API

REST API base: `/api/v1/`

- `GET /api/v1/health` — platform health & enabled modules
- `GET /api/v1/ai/status` — AI provider status
- `POST /api/v1/ai/chat` — chatbot API (`message`, optional `session_id`)
- `GET /api/v1/ai/history/{sessionId}` — conversation history
- Module routes: `/api/v1/{module}/...`
- Authenticated: `Authorization: Bearer {sanctum_token}`

## AI Chatbot & External APIs

The floating chatbot (bottom-right on every page) supports multiple AI backends with automatic fallback.

### Built-in providers
- **OpenAI** — set `AI_PROVIDER=openai` and `AI_API_KEY`
- **Anthropic** — set `AI_PROVIDER=anthropic` and `AI_ANTHROPIC_API_KEY`

### Connect APIs from your other projects

Set `AI_PROVIDER` to one of: `external`, `tourism_os`, `eventos`, `marketplace_ai`

Example — connect your TourismOS API:

```env
AI_PROVIDER=tourism_os
AI_TOURISM_OS_ENABLED=true
AI_TOURISM_OS_URL=https://api.your-tourism-project.com
AI_TOURISM_OS_API_KEY=your-api-key
AI_TOURISM_OS_CHAT_ENDPOINT=/api/ai/chat
AI_TOURISM_OS_RESPONSE_KEY=message
```

Example — generic external API:

```env
AI_PROVIDER=external
AI_EXTERNAL_ENABLED=true
AI_EXTERNAL_BASE_URL=https://api.your-project.com
AI_EXTERNAL_CHAT_ENDPOINT=/api/v1/chat
AI_EXTERNAL_API_KEY=your-key
AI_EXTERNAL_RESPONSE_KEY=reply
AI_FALLBACK_CHAIN=external,openai
```

The external provider sends `{ message, messages, conversation, context }` and reads the response from your configured key (`reply`, `message`, `response`, etc.).

See `config/ai-providers.php` to add more project APIs.

## White-label / Multi-city

Configure via `.env`:

```
PLATFORM_NAME="Munich Festival OS"
PLATFORM_DEFAULT_CITY=Munich
PLATFORM_WHITE_LABEL=true
```

## Security

- CSRF, XSS protection, rate limiting
- Security headers middleware
- 2FA via Fortify
- Spatie roles (guest → super_admin)
- Audit logs table ready

## Email verification (Hostinger)

Dashboard access requires a verified email (`/email/verify`).

1. Create a mailbox in hPanel (e.g. `noreply@oktoberhub.de`)
2. Set SMTP in `.env`:

```env
APP_URL=https://oktoberhub.de
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=noreply@oktoberhub.de
MAIL_PASSWORD=your-mailbox-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@oktoberhub.de
```

3. Ensure cron is running (`php artisan schedule:run` every minute)

**Unlock a stuck user via SSH** (when mail is blocked):

```bash
php artisan users:verify user@example.com
```

## Next Steps

This foundation includes homepage, search, AI trip planner, auth, admin dashboard, core schema, and module scaffolding. Extend each module independently:

1. Implement Payments webhooks (Stripe/PayPal)
2. Build vendor onboarding & KYC flows
3. Add booking calendars for Rental/Hotel
4. Connect Digital Twin map APIs
5. Expand REST API for mobile apps

## License

MIT
