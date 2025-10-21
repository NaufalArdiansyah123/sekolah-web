# Repository Guidelines

## Project Structure & Module Organization

- app/ — Laravel application code: Http (Controllers, Middleware, Requests), Models, Services, Traits, Console, View (Components, Composers), Helpers, Exports/Imports.
- routes/ — Route definitions for web, auth, and API: routes/web.php, routes/auth.php, routes/api.php.
- resources/ — Frontend assets and Blade templates: resources/css, resources/js, resources/views.
- public/ — Web root (index.php), built assets, images; Vite outputs are served here.
- config/ — Application configuration files.
- database/ — factories/, migrations/, seeders/.
- tests/ — PHPUnit tests in Feature/ and Unit/.
- Tooling at root: composer.json, package.json, vite.config.js, tailwind.config.js, postcss.config.js, phpunit.xml, artisan.

## Build, Test, and Development Commands

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Start Vite dev server (frontend assets with HMR)
npm run dev

# Build production assets
npm run build

# Run the Laravel app (local PHP dev server)
php artisan serve

# Run tests
./vendor/bin/phpunit

# Code style (Laravel Pint)
./vendor/bin/pint
```

## Coding Style & Naming Conventions

- Indentation: 4 spaces (.editorconfig); LF endings; UTF-8.
- PHP: PSR-4 autoloading under App\ namespace (composer.json). Classes in StudlyCase, one class per file (e.g., app/Http/Controllers/Admin/DashboardController.php).
- Views: Blade templates in resources/views use kebab/snake case for filenames.
- JS/CSS: resources/js and resources/css built via Vite; Tailwind configured in tailwind.config.js.
- Linting/formatting: Laravel Pint via ./vendor/bin/pint.

## Testing Guidelines

- Framework: PHPUnit ^10 (phpunit.xml).
- Test files: tests/Feature/*Test.php, tests/Unit/*Test.php.
- Running tests: ./vendor/bin/phpunit
- Coverage: Not specified.

## Commit & Pull Request Guidelines

- Commit messages: No strict convention enforced; recent examples include short Indonesian notes (e.g., "sedikit perbaikan", "perubahan fasilitas"). Prefer clear, imperative messages (feat:, fix:, chore:).
- PRs: Ensure tests pass, assets build, and remove/guard debug routes in routes/web.php before merging.
- Branch naming: Suggested pattern feature/<summary>, bugfix/<summary>, chore/<summary>.

---

# Repository Tour

## 🎯 What This Repository Does

sekolah-web is a Laravel 10-based school website and management portal providing public pages and authenticated dashboards for admins, teachers, students, and guru piket.

**Key responsibilities:**
- Public-facing site for news, agenda, facilities, study programs, gallery, videos, and contact
- Admin CMS for content, users/roles, settings, backups, school profile
- Teacher/Student workflows for assignments, attendance (QR), quizzes, and grades

---

## 🏗️ Architecture Overview

### System Context
```
Browser/Client → Laravel (routes/* → Controllers in app/Http/*) → Database (config/database.php)
                              ↓
                        Frontend Assets (Vite/Tailwind from resources/* → public/)
```

### Key Components
- Routing layer: routes/web.php, routes/auth.php define public, auth, and role-protected areas.
- Controllers: app/Http/Controllers/{Admin,Teacher,Student,GuruPiket,Public,Auth} implement domain features.
- Models: app/Models Eloquent entities and relations.
- Views: resources/views Blade templates, styled with Tailwind; JS via Alpine.js.
- Services/Traits/Helpers: app/Services, app/Traits, app/Helpers for cross-cutting logic.
- Asset pipeline: vite.config.js, tailwind.config.js, postcss.config.js manage builds to public/.

### Data Flow
1. Request hits routes/web.php; middleware applies auth and role guards (admin, teacher, student, guru_piket).
2. Controller validates and executes business logic, interacts with Eloquent models and services.
3. Data persists in DB; media via spatie/laravel-medialibrary; roles via spatie/laravel-permission.
4. Response returned as Blade views or JSON; assets served from public/.

---

## 📁 Project Structure [Partial Directory Tree]

```
.
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Exports/
│   ├── Helpers/
│   ├── Http/
│   │   ├── Controllers/{Admin,Auth,GuruPiket,Public,Student,Teacher}
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Imports/
│   ├── Models/
│   ├── Providers/
│   ├── Services/
│   ├── Traits/
│   └── View/{Components,Composers}
├── routes/{web.php,auth.php,api.php}
├── resources/{css,js,views}
├── public/
├── config/
├── database/{factories,migrations,seeders}
├── tests/{Feature,Unit}
├── vite.config.js, tailwind.config.js, postcss.config.js
├── composer.json, package.json, phpunit.xml, artisan
└── README.md
```

### Key Files to Know

| File | Purpose | When You'd Touch It |
|------|---------|---------------------|
| routes/web.php | Main HTTP routes, role-protected domains | Add public pages or dashboard routes |
| routes/auth.php | Auth scaffolding (Breeze) | Modify login/register/reset flows |
| app/Http/Controllers/* | Controllers per domain | Implement feature logic |
| app/Models/* | Eloquent models | Define schema/relations |
| resources/views/* | Blade view templates | UI and layout changes |
| vite.config.js | Vite entry points/HMR | Tweak asset pipeline |
| tailwind.config.js | Theme and content globs | Adjust design system |
| phpunit.xml | Test suites and env | Configure tests |
| composer.json | PHP dependencies and scripts | Add/upgrade packages |
| package.json | Frontend deps and scripts | Asset tooling and Qodo CLI scripts |

---

## 🔧 Technology Stack

### Core Technologies
- Language: PHP ^8.1 (composer.json)
- Framework: Laravel ^10.10 (composer.json)
- Frontend: Vite 5, TailwindCSS 3, Alpine.js 3 (package.json, tailwind.config.js)
- Database: Configured via environment and config/database.php
- AuthZ: spatie/laravel-permission for roles/permissions (composer.json)

### Key Libraries
- spatie/laravel-permission — role/permission management
- spatie/laravel-medialibrary (10.8) — media management
- maatwebsite/excel — import/export Excel/CSV
- barryvdh/laravel-dompdf — PDF generation
- endroid/qr-code — QR code generation
- guzzlehttp/guzzle — HTTP client
- intervention/image — image manipulation

### Development Tools
- PHPUnit 10 — testing (phpunit.xml)
- Laravel Pint — code style formatter
- Vite/Tailwind/PostCSS — asset build pipeline

---

## 🌐 External Dependencies

- Database configured via .env and config/database.php.
- Mailer via MAIL_* in .env (phpunit.xml uses array mailer for tests).

### Environment Variables

Refer to .env.example and phpunit.xml:

```bash
APP_ENV=testing
CACHE_DRIVER=array
QUEUE_CONNECTION=sync
SESSION_DRIVER=array
MAIL_MAILER=array
```

---

## 🔄 Common Workflows

- Public site: routes in routes/web.php for home, about, news, agenda, gallery, facilities, achievements, study programs, videos, contact, downloads.
- Authentication: routes/auth.php (Laravel Breeze); /dashboard redirects by role in routes/web.php.
- Admin CMS: routes under /admin for posts (slideshow, blog, agenda, announcements), media/videos, facilities, achievements, study-programs, users/roles, downloads, settings, backups, notifications, calendar, school-profile, history, contacts, student registrations, security violations.
- Teacher portal: /teacher for assignments, learning materials, posts, students, attendance (QR + submissions), quizzes, grades.
- Guru Piket: /guru-piket for attendance scanning, student/teacher attendance management, teacher submissions processing.
- Student portal: /student for profile, notifications, attendance (QR display/history/export), grades. (Routes referenced by controllers; see routes/web.php for redirects and groupings.)

---

## 📈 Performance & Scale

- Use Vite production build (npm run build). Tailwind content globs purge unused CSS (tailwind.config.js).
- Laravel caches in production: php artisan config:cache, route:cache, view:cache.

---

## 🚨 Things to Be Careful About

### 🔒 Security Considerations
- Ensure role middleware on admin/teacher/guru_piket/student routes remains intact.
- Remove or guard debug routes in routes/web.php (e.g., /debug/session/*, /settings/test-*).
- Files/media: Ensure storage symlink (php artisan storage:link) and filesystem config for media library. Validate file uploads.


*Update to last commit: 4ff5112617b0aafaef173a753dae9dd8ec354cdd*
