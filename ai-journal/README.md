# AI Journal

AI-powered manuscript review platform for academic journals. Built with **PHP Laravel**.

Journals can register on the platform, authors submit manuscripts, and the system automatically reviews articles across seven academic quality criteria — delivering structured scores, feedback, and editorial recommendations in under a minute.

## Features

- **Landing page** with platform overview and participating journals
- **Role-based access**: Admin, Journal Editor, Author
- **Journal management** — editors create and manage multiple journals
- **Article submission** — authors submit manuscripts with title, abstract, keywords, and full text
- **AI review engine** — automated analysis across 7 criteria:
  - Originality & Contribution
  - Methodology Rigor
  - Clarity & Writing Quality
  - Structure & Organization
  - Literature & References
  - Research Ethics
  - Reproducibility
- **Review reports** — scores, strengths/weaknesses/suggestions, flagged issues, and accept/revise/reject recommendations
- **Editor notes** — private notes on review reports
- **Optional OpenAI integration** — set `OPENAI_API_KEY` for GPT-powered reviews (falls back to rule-based analysis)

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+
- SQLite (default) or MySQL/PostgreSQL

## Installation

```bash
cd ai-journal
composer install
cp .env.example .env   # if needed
php artisan key:generate
touch database/database.sqlite   # if using SQLite
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

Visit `http://localhost:8000`

## Demo Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@aijournal.test | password |
| Journal Editor | editor@aijournal.test | password |
| Author | author@aijournal.test | password |

## OpenAI Integration (Optional)

Add to `.env`:

```
OPENAI_API_KEY=sk-your-key-here
OPENAI_MODEL=gpt-4o-mini
```

When configured, reviews use OpenAI for deeper analysis. Without a key, the built-in rule-based engine handles all reviews.

## Architecture

```
app/
├── Http/Controllers/     # Home, Dashboard, Journal, Article, Review
├── Models/               # User, Journal, Article, Review
├── Services/
│   └── AiReviewService.php   # Core AI review logic
└── Http/Middleware/
    └── EnsureUserHasRole.php # Role-based access control
```

## License

MIT
