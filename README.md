# Social Scheduler

A Laravel web application for connecting social accounts, preparing posts with optional media, and scheduling posts for Facebook, Instagram, and LinkedIn.

## Features

- User registration, login, profile management, and authenticated post management.
- Connect Facebook, Instagram, and LinkedIn accounts through their OAuth flows.
- Create, edit, view, cancel, and delete scheduled posts.
- Schedule in a selected timezone; store scheduled times in UTC and display them in the selected timezone.
- Upload images and videos to Laravel's public storage disk and preview media with posts.
- Check due posts every minute and dispatch platform-specific publishing jobs.
- Track scheduled, pending, publishing, published, failed, and cancelled post states.
- View notifications and activity logs.

## Requirements

- PHP 8.2 or later with the extensions required by Laravel 12.
- Composer.
- A database supported by the configured Laravel connection (the project environment determines which one is used).
- Node.js and npm for frontend assets.
- OAuth applications and valid credentials for each social platform you intend to connect.

## Local setup

1. Install PHP dependencies:

   ```bash
   composer install
   ```

2. Create your local environment file and application key:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   On Windows PowerShell, use `Copy-Item .env.example .env` instead of `cp`.

3. Configure `.env` with your application URL, database connection, session/cache settings, and social OAuth credentials. Do not commit `.env` or expose access tokens and client secrets.

   The social integration settings used by the application are:

   | Platform | Environment keys |
   | --- | --- |
   | Facebook | `FACEBOOK_CLIENT_ID`, `FACEBOOK_CLIENT_SECRET`, `FACEBOOK_REDIRECT_URI` |
   | Instagram | `INSTAGRAM_CLIENT_ID`, `INSTAGRAM_CLIENT_SECRET`, `INSTAGRAM_REDIRECT_URI` |
   | LinkedIn | `LINKEDIN_CLIENT_ID`, `LINKEDIN_CLIENT_SECRET`, `LINKEDIN_REDIRECT_URI` |

   Set each provider's registered callback URL to match the configured application URL and redirect URI:

   - Facebook: `/auth/facebook/callback`
   - Instagram: `/auth/instagram/callback`
   - LinkedIn: `/auth/linkedin/callback`

4. Create/configure the database, then run migrations when setting up a new or intentionally unmigrated database:

   ```bash
   php artisan migrate
   ```

   Do not run migrations against an existing database unless you have reviewed the pending migrations and have an appropriate backup.

5. Install frontend dependencies and build assets:

   ```bash
   npm install
   npm run build
   ```

6. Create the standard public-storage link for uploaded post media:

   ```bash
   php artisan storage:link
   ```

## Run locally

Start each process in its own terminal:

```bash
php artisan serve

```
ngrok http 8000 

```bash
npm run dev
```

```bash
php artisan queue:work
```

```bash
php artisan schedule:work
```

The scheduler runs `posts:check-scheduled` every minute. That command finds due posts and dispatches the appropriate publishing job. The queue worker processes dispatched jobs; both the scheduler and worker must be running for automatic scheduled publishing. The queue connection is controlled by `QUEUE_CONNECTION` (the Laravel configuration defaults to the database queue).

For a production deployment, configure Laravel's scheduler to invoke `php artisan schedule:run` every minute and keep a queue worker running under a process manager.

## Scheduling and publishing

- A post is saved with its selected timezone and scheduled instant converted to UTC.
- The due-post command selects due `scheduled` or `pending` posts and dispatches a Facebook, Instagram, or LinkedIn job.
- Publishing results and errors are reflected in the post status and related post metadata.
- Facebook OAuth requests the Page permissions `pages_show_list`, `pages_read_engagement`, and `pages_manage_posts`. Publishing uses the first manageable Page returned by Facebook for the connected account.
- Instagram publishing requires at least one image or video.
- Post media is stored on Laravel's `public` disk under `storage/app/public`; the `public/storage` link makes it available to the application.

Social platforms can change API requirements, permissions, and account eligibility. Configure and authorize each integration in the provider's developer portal before connecting it in the application.

## Tests

Run the automated test suite with:

```bash
php artisan test
```

Tests that exercise external social APIs should use mocked HTTP responses; use real platform credentials only for a deliberate integration test.

## Project layout

- `app/Http/Controllers` — web, post, account, and social OAuth controllers.
- `app/Models` — users, social accounts, scheduled posts, post media, and related records.
- `app/Jobs` — Facebook, Instagram, and LinkedIn publishing jobs.
- `app/Console/Commands/CheckScheduledPosts.php` — finds due posts and dispatches publishing jobs.
- `routes/web.php` — web, authentication-protected post, account, and OAuth routes.
- `routes/console.php` — scheduled command definitions.
- `resources/views` — Blade pages and shared layouts.
- `database/migrations` — database schema definitions.

## License

This application includes Laravel and other open-source dependencies. See the relevant package licenses and repository files for licensing information.
