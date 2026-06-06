# Sanctum Backend API

Sanctum Backend API is the Laravel REST API that powers the Sanctum Catholic prayer and catechism app. It serves authentication, progress tracking, daily reflections, saints, rosary progress, peace sessions, prayer sessions, and the Ask Catechism chatbot.

## Tech Stack

- Laravel REST API
- MySQL for local development
- Laravel Sanctum authentication
- Ollama local AI for development
- Future deployment support for cloud database and cloud AI API

## Local Setup

1. Install dependencies:

```bash
composer install
```

2. Create the local environment file:

```bash
cp .env.example .env
```

3. Generate the application key:

```bash
php artisan key:generate
```

4. Configure your database in `.env`.

5. Run migrations and seeders:

```bash
php artisan migrate --seed
```

6. Start the backend:

```bash
php artisan serve
```

## API Base URL

http://127.0.0.1:8000/api

## Important Endpoints

- `POST /api/register`
- `POST /api/login`
- `POST /api/logout`
- `GET /api/me`
- `GET /api/home`
- `GET /api/dashboard-stats`
- `POST /api/prayer-sessions`
- `POST /api/peace-sessions`
- `GET /api/daily-reflection`
- `POST /api/daily-reflection/read`
- `GET /api/saint-of-the-day`
- `POST /api/ask-catechism`
- `GET /api/rosary-progress`
- `POST /api/rosary-progress`

## Deployment Notes

- Do not commit `.env`.
- Do not commit `vendor`.
- The backend must be running for the Flutter app to connect locally.
- The repo is prepared for later deployment with a cloud database and cloud AI provider, but local development still uses MySQL and Ollama.

## GitHub Upload Checklist

- Confirm `.env` is ignored.
- Confirm `.env.example` contains only safe placeholder values.
- Confirm `composer.json` and `composer.lock` are included.
- Confirm `storage` and `bootstrap/cache` contain placeholder `.gitignore` files.

## License

This project uses the MIT License.
