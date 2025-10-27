# Contributing

Thanks for your interest in contributing to Modern Barbershop.

Getting started (local):

1. Install PHP, Composer, Node.js and npm.
2. Copy environment and generate key:

```powershell
Copy-Item .env.example .env
php artisan key:generate
New-Item -Path database\database.sqlite -ItemType File -Force
```

3. Install dependencies:

```powershell
composer install
npm install
```

4. Run migrations and seeders:

```powershell
php artisan migrate --seed
```

5. Run tests:

```powershell
php artisan test
```

Guidelines

-   Open a small, focused pull request.
-   Add tests for new behavior.
-   Keep UI changes accessible and responsive.

Code style

-   Follow PSR-12 for PHP.
-   Use Tailwind for UI styling.

Thank you — we look forward to your contributions!
