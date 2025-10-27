# Modern Barbershop App 💈

A modern, mobile-responsive web application for managing barbershop appointments. Built with Laravel, Jetstream, and Tailwind CSS for a fast developer experience and an elegant UI.

---

## Quick overview

-   Secure user registration & login (Jetstream)
-   View services (haircuts, beard trims, treatments)
-   Book, reschedule, or cancel appointments
-   Manage staff availability & schedules
-   Admin dashboard for service and booking management

This repository contains an MVP-ready Laravel 11 application using SQLite for easy local development.

## Features (MVP)

-   Secure authentication and user profiles (Laravel Jetstream)
-   Browse available services and staff
-   Book appointments with available staff slots
-   Reschedule or cancel appointments from the user dashboard
-   Staff availability management
-   Admin dashboard to manage services and bookings

## Tech Stack

-   Backend: Laravel 11 (PHP 8.2+)
-   Frontend: Blade + Tailwind CSS v4
-   Authentication: Laravel Jetstream
-   Database: SQLite (development-friendly)
-   Dev tooling: Vite, npm, Composer

## Prerequisites

-   PHP 8.2 or newer
-   Composer
-   Node.js & npm
-   Git

## Getting started (local development)

1. Clone the repository

```bash
git clone https://github.com/YOUR_USERNAME/modern-barbershop-app.git
cd modern-barbershop-app
```

2. Install PHP dependencies

```bash
composer install
```

3. Install Node dependencies

```bash
npm install
```

4. Copy the environment file and generate an app key

Unix / macOS:

```bash
cp .env.example .env
php artisan key:generate
```

Windows (PowerShell):

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

5. Configure SQLite (recommended for local dev)

Create the SQLite database file:

Unix / macOS:

```bash
mkdir -p database
touch database/database.sqlite
```

Windows (PowerShell):

```powershell
New-Item -Path database\\database.sqlite -ItemType File -Force
```

Then update your `.env` to use SQLite (these are the defaults):

```
DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite  # typically left empty for sqlite when using connection=sqlite
```

6. Run migrations & seeders

```bash
php artisan migrate --seed
```

7. Build assets (optional during development; Vite dev server also supported)

```bash
npm run dev
# or for production-ready assets:
npm run build
```

8. Start the local server

```bash
php artisan serve
```

Visit http://localhost:8000 in your browser.

## Local test credentials

For convenience the database seeder creates a test admin user you can use during local development:

-   Email: `test@example.com`
-   Password: `password`

Use the Dashboard (after logging in) to access admin pages under `/admin`.

## CI note

The GitHub Actions workflow included with this repo runs the test suite using SQLite to mirror the local development environment and keep CI runs fast.

## Project structure

High-level layout of important folders:

-   `app/` — Models, Controllers, Actions, Providers
-   `routes/` — `web.php`, `api.php`, etc.
-   `resources/` — Blade views and frontend assets
-   `database/` — Migrations, factories, seeders
-   `public/` — Public assets and front controller
-   `tests/` — Feature and Unit tests

## Tests

Run the test suite with PHPUnit:

```bash
./vendor/bin/phpunit
```

Or using Artisan:

```bash
php artisan test
```

## Deployment

This app can be deployed using standard Laravel deployment strategies. Common options:

-   Laravel Forge (recommended for simple server provisioning)
-   Laravel Vapor (for serverless deployments)
-   Manual deploy to a VPS or shared host

Make sure to set production environment variables, run migrations, and compile production assets (`npm run build`) on deploy.

## Roadmap

-   Online payments integration (Stripe, Mollie, PayPal)
-   Loyalty points & membership system
-   Multi-branch support & management
-   AI-based slot recommendation and smart scheduling

## Contributing

Contributions are welcome. To contribute:

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-feature`
3. Make your changes and add tests if applicable
4. Submit a pull request describing your changes

For major changes, open an issue first so we can discuss design and scope.

## License

This project is released under the MIT License. See the `LICENSE` file for details.

---
