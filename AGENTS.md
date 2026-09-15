# bluecoolant

Laravel 8 multi-language CMS/theme (Xgenious "Zixer" CodeCanyon script) deployed as **bluecoolant.com**. Frontend marketing site + admin panel + user area + payment gateways.

## Project

- **Stack:** PHP 7.4 (composer `^7.4`) / Laravel 8.83 · MySQL · Blade · laravel-mix (webpack) · PHPUnit 9.
- **Layout is non-standard:** the Laravel app lives entirely in **`@core/`**; the repo root is the web doc root.
  - `index.php` (repo root) is the front controller — it requires `@core/vendor/autoload.php` and `@core/bootstrap/app.php`.
  - Public assets are served from the **repo-root `assets/`** dir (not `@core/public`). `.env` sets `ASSET_URL=https://bluecoolant.com`; views reference `asset('assets/...')`.
  - Uploads land in `assets/uploads/`.
- **Entry points:** `index.php` (HTTP), `@core/artisan` (CLI).
- `@core/.env` is committed (contains live credentials — never echo or copy secrets out); there is **no `.env.example`**.

## Commands

All Laravel/artisan commands run from `@core/`, not the repo root.

```bash
cd @core                     # required working dir for artisan/tests/npm
php artisan serve            # dev server
php artisan migrate          # run migrations (database/migrations)
php artisan db:seed          # DatabaseSeeder
php artisan key:generate
php artisan route:list

composer install             # from @core/
npm run dev                  # or: npm run watch / npm run prod  (from @core/, laravel-mix)
                             # -> builds resources/js/app.js, resources/sass/app.scss to @core/public/{js,css}

php vendor/bin/phpunit       # from @core/  (see Notes: currently blocked in this env)
```

DB dumps for seeding a local DB live at the repo root: `kpexovto_liq_dk_blu3c0olan.sql` (main), `..._backup.sql`, `kpexovto_bc.sql`.

## Architecture

- **`@core/app/*.php` — Eloquent models at the namespace root** (e.g. `App\Admin`, `App\User`, `App\Services`, `App\Works`, `App\Blog`, `App\Order`, `App\PaymentLogs`, `App\StaticOption`, `App\Language`). **Not** `App\Models`.
- **`@core/app/Http/Controllers/`** — one controller per admin section (`ServiceController`, `WorksController`, `BlogController`, …), plus `FrontendController` (all public-facing pages), `UserDashboardController`, and `Auth/*`.
- **`@core/routes/web.php`** (~44 KB, effectively all routing; `api.php` is minimal). Three areas:
  - public routes in a `['setlang','globalVariable','maintains_mode']` group, page slugs read from `get_static_option(...)`;
  - `admin-home` prefix = admin panel (also `/login/admin`);
  - `user-home` prefix = logged-in user area.
- **`@core/app/Helpers/helpers.php`** — autoloaded globally via composer `files`. Load-bearing helpers: `get_static_option` / `update_static_option` / `set_static_option` (DB-backed site settings), `get_user_lang` / `get_default_language` / `get_language_by_slug`, `render_image_markup_by_attachment_id`, `render_menu_by_id`, `render_payment_gateway_for_form`, `licnese_cheker` (sic).
- **`@core/app/Http/Middleware/`** — custom: `SetLang`, `GlobalVariableMiddleware` (view composer injecting global vars into every view), `MaintainsMode`, `UserRoleCheck` alias `capability`, `UserEmailVerify`, `Demo`.
- **`@core/app/PaymentGateway/`** — `PaymentGatewayBase` + `Gateways/{Paypal,StripePay,Razorpay,PaystackPay,MolliePay,Paytm,FlutterWaveRave}`; per-gateway config in `@core/config/{paypal,paystack,flutterwave}.php`, keys in `.env`.
- **`@core/app/WidgetsBuilder/`** — widget system (`WidgetBase` + `Widgets/*`), rendered via helpers.
- **`@core/app/Providers/LicenseServiceProvider.php` + `@core/license.json`** — Xgenious license check, triggered on `admin-home` requests.
- **`@core/resources/views/`** — Blade: `backend/`, `frontend/` (with `home-pages/home-01..03` variants, `pages/`, `partials/`), `components/`, `layouts/`, `mail/`, `invoice/`.
- **Auth guards** (`config/auth.php`): `web` → `App\User`; `admin` → `App\Admin`. Admin controllers gate via `$this->middleware('auth:admin')` in the constructor.

## Conventions

- **Models live at `App\` root** (`@core/app/Foo.php`) — put new models there, not under `app/Models`.
- **Site settings go through static options:** read with `get_static_option('key')`, write with `update_static_option('key', $value)` (backed by the `StaticOption` model / `static_options` table). Don't hardcode settings.
- **Multi-language:** content models carry a `lang` column; resolve the active language with `get_user_lang()` (session `lang`, falls back to default) and query with `Language`/`get_default_language()`. Translation files under `@core/resources/lang/`.
- **Controllers stay thin:** validate inline, `return view('backend.pages.x.index')->with([...])`; admin section controllers protect themselves with `auth:admin` in `__construct`.
- **Frontend assets:** reference via `asset('assets/frontend|backend|common/...')` (repo-root `assets/`). The laravel-mix build (`resources/{js,sass}` → `@core/public`) is separate from that vendored asset tree.
- **Styles/CSS:** `@core/public/css` and `@core/public/js` hold only the mix-built `app.*` bundles.

## Notes

- **PHP version mismatch:** this machine ships PHP **8.3**, but `composer.json` requires `^7.4` (Laravel 8). `php artisan` currently runs, but keep to 7.4-compatible syntax.
- **PHPUnit is not runnable here:** the `mbstring` extension is missing (`php -m`), and `gd` is also absent (needed by `intervention/image`). Install `php-mbstring` (+ `php-gd`) before running `php vendor/bin/phpunit`. `tests/` holds only the default `ExampleTest`s, which hit `/` and therefore need a seeded DB with `StaticOption` rows.
- No git repository is initialized in this directory.
