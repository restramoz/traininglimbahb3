# TrainingLimbahB3 — Technical Plan

## Objective
Deliver a functional first version of TrainingLimbahB3 in one day by reusing suitable Laravel functionality from the copied project, while keeping the original K3 project untouched.

## Approved Decisions

### Service Categories

#### Sertifikasi & Pelatihan
1. Training PPPA
2. Training IPAL
3. Training POIPPU
4. Training PLB3
5. Training OLB3
6. Training PPPU
7. Training PCUA

#### Jasa Konsultansi & Pengujian
8. Jasa Uji Emisi Lingkungan
9. Jasa UKL-UPL
10. Jasa Pertek Lingkungan
11. Jasa Rintek Lingkungan
12. Jasa RKL-RPL Lingkungan
13. Jasa Transportasi dan Pengelolaan Limbah B3

### Article Generator
- Minimum: 800 words
- Maximum: 3000 words
- Default: 1500 words
- Keep form validation, controller validation, and AI prompt limits consistent.
- Do not auto-publish AI-generated content.
- Avoid long synchronous generation loops that risk HTTP timeouts.

### Visual Identity
- Industrial Navy: #0B192C
- Environmental Emerald: #059669 / #10B981
- Use navy for structure and trust; emerald for environmental accents.

## Audit Findings Reported So Far

- Laravel CLI works; `php artisan --version` returned Laravel Framework 13.36.0.
- `composer check-platform-reqs` passed all reported platform requirements.
- `vendor/` and `node_modules/` exist.
- npm scripts available: `build` and `dev`.
- `.env` points DB_DATABASE to `/root/TrainingLimbahB3/database/traininglimbahb3.sqlite`.
- The target SQLite database was previously reported as empty and unmigrated. Recheck its current state before any migration.
- Legacy K3 data must remain isolated and must never be imported.
- Reported reusable components include HtmlSanitizerService, ImageUploadService, RegionalService, CreateAdminCommand, and modular admin CMS code. Verify actual behavior before relying on them.
- Reported issues include K3-specific routes/controllers/views, no sitemap.xml, and robots.txt needing review.
- The existing article generator was reported to validate 6000–7000 words and use up to eight continuation loops. Inspect actual code before modifying.

## P0 — Minimum Functional Release
1. Inspect current project and existing changes after interruption.
2. Verify dependencies, environment, and SQLite path. Do not reinstall dependencies unnecessarily.
3. Replace K3-specific branding and service content in homepage, navigation, footer, routes, controllers, and views.
4. Implement all 13 services through structured data and reusable dynamic templates.
5. Verify homepage, service detail pages, admin authentication, and WhatsApp CTAs.
6. Preserve sanitization, upload validation, CSRF, authentication, and authorization.

## P1 — SEO and Quality
1. Implement or verify sitemap.xml.
2. Review robots.txt, canonical URLs, metadata, and breadcrumbs.
3. Reuse regional data and routes where appropriate for provinces and regencies/cities.
4. Avoid thin, duplicated mass-generated regional pages and fabricated service-area claims.
5. Apply article generation limits consistently.
6. Build frontend assets and run available tests and smoke checks.
7. Report deployment requirements and unresolved blockers.

## Safety Constraints
- Work only inside `/root/TrainingLimbahB3`.
- Never modify the original K3 source project.
- Never import legacy K3 SQL dumps or database contents.
- Never run `migrate:fresh`, `db:wipe`, or destructive database commands.
- Verify the active database connection and exact path before migrations.
- Do not expose .env secrets, credentials, password hashes, or database contents.
- Do not assume paid APIs/services are available.
- Do not claim runtime verification without running the relevant check.
- Make changes incrementally and preserve valid existing work.

## Recovery After Interruption
Before resuming:
1. Inspect repository state and current source files.
2. Identify completed, partial, and pending tasks.
3. Check whether frontend build artifacts and database migrations already exist.
4. Do not repeat installations or overwrite files without evidence.
5. Continue from the first incomplete task.
6. Summarize files changed, checks run, failures, and remaining tasks after each logical stage.
