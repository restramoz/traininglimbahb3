# Feature Parity Checklist — P3K to K3 Konstruksi

**Reference Project (READ-ONLY)**: `/root/sertifikasip3k`  
**Target Project**: `/root/sertifikasi-k3-konstruksi`  
**Target Domain**: `sertifikasik3konstruksi.my.id`  
**Target Focus**: Sertifikasi & Pelatihan K3 Konstruksi (Muda, Madya, Utama)

---

## 1. Public Core & Program Pages

| Feature | Reference Source File(s) | Functional Behavior | Target Status | Dependencies / Requirements | Verification Method |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Homepage** | `resources/views/home.blade.php`, `HomeController.php` | Industrial safety landing page with value props, FAQ, hero, programs, and CTA | **Implemented & Verified** | Tailored to K3 Konstruksi, zero P3K medical copy | `HomepageDesignTest` (Status 200, semantic landmarks) |
| **Program Pages (Muda, Madya, Utama)** | *Not in P3K (new K3 scope)* | Dedicated landing pages for 3 K3 Construction qualification levels | **Implemented & Verified** | `ProgramController.php`, `programs/show.blade.php` | `ProgramPagesTest` (12 tests, 84 assertions) |
| **WhatsApp Conversion Integration** | `app/Support/WhatsApp.php`, `components/wa-cta.blade.php`, `wa-float.blade.php` | Dynamic WhatsApp CTA formatting with context-aware messages and configurable number | **Implemented & Verified** | Uses `config('services.whatsapp')`, no hardcoded numbers | `WhatsAppTest`, `WhatsAppConversionFlowTest` |

---

## 2. Regional Landing Pages & Routing

| Feature | Reference Source File(s) | Functional Behavior | Target Status | Dependencies / Requirements | Verification Method |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **BPS Wilayah Dataset** | `master_wilayah_bps.json` | 7,288 official BPS records (38 provinces, 514 cities, 7,288 districts) | **Implemented & Verified** | Fast PHP bytecode cache (`k3_wilayah_cache.php`) | Dataset integrity tests (38 provs, 514 cities) |
| **Province Pages** | `resources/views/regional/province.blade.php` *(enhanced from P3K)* | Listing of all kab/kota in province, statistics, 3 K3 programs, disclaimer | **Implemented & Verified** | `/provinsi/{slug}` route | `RegionalPagesTest::test_province_page_renders_successfully` |
| **City / Regency Pages** | `CityPageController.php`, `resources/views/city-page.blade.php` | Dynamic landing for kota & kabupaten, district list, nearby cities, FAQ | **Implemented & Verified** | `/kota/{slug}`, canonical alias redirects (e.g. `/kota/kota-bandung` -> `/kota/bandung`) | `RegionalPagesTest::test_city_page_renders_successfully` |
| **District Pages** | `DistrictPageController.php`, `resources/views/district-page.blade.php` | Sub-district reference page with sibling navigation, validated against parent city | **Implemented & Verified** | `/kecamatan/{citySlug}/{districtSlug}`, `noindex` tag, 404 on mismatched city | `RegionalPagesTest::test_district_page_renders_successfully` |
| **Regional Legacy Route Aliases** | `routes/web.php` (`/kota-{slug}`, `/kecamatan-{slug}`) | Route compatibility for hyphenated city/district URLs | **To Port in Stage B** | Add safe redirects to canonical `/kota/{slug}` and `/kecamatan/{city}/{dist}` | Smoke tests & route tests |

---

## 3. Article System (Public)

| Feature | Reference Source File(s) | Functional Behavior | Target Status | Dependencies / Requirements | Verification Method |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Public Article Index** | `PublicArticleController@index`, `resources/views/articles/index.blade.php` | Paginated listing of published articles with cover image, excerpt, city badge | **To Port in Stage C** | Migration `create_articles_table`, `Article` model | HTTP GET `/artikel` test |
| **Public Article Detail** | `PublicArticleController@show`, `resources/views/articles/show.blade.php` | Article detail view with HTML sanitization, FAQs, related articles, JSON-LD Schema | **To Port in Stage C** | Schema.org Article & FAQPage, K3 construction topics | HTTP GET `/artikel/{slug}` test |
| **Draft Protection** | `PublicArticleController@show` | Unpublished / draft articles return 404 to public visitors | **To Port in Stage C** | `scopePublished` on `Article` model | Assert 404 for draft status |
| **Security: Prompt Isolation** | `resources/views/articles/show.blade.php` | AI image prompt / brief is never exposed on public pages | **To Port in Stage C** | Strict Blade field whitelisting | `assertDontSee` test for AI prompt |

---

## 4. Admin Panel & Content Management

| Feature | Reference Source File(s) | Functional Behavior | Target Status | Dependencies / Requirements | Verification Method |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Admin Authentication & Guard** | `LoginController.php`, `EnsureUserIsAdmin.php`, `auth/login.blade.php` | Secure session login/logout with `is_admin` verification | **To Port in Stage D** | `is_admin` column in `users` table | `AdminAuthTest` |
| **Admin Create CLI Command** | `app/Console/Commands/CreateAdminCommand.php` | Safe console creation / update of admin account | **To Port in Stage D** | `php artisan admin:create` | Command execution test |
| **Admin Layout & Navigation** | `resources/views/admin/layout.blade.php` | Admin layout with responsive navbar, flash alerts, and K3 theme | **To Port in Stage D** | Redesigned with Navy/Safety Yellow K3 theme | Blade render test |
| **Article CRUD (Index/List)** | `Admin/ArticleController@index`, `admin/articles/index.blade.php` | Search by title/slug/city, filter by draft/published status, pagination | **To Port in Stage D** | Paginated Eloquent query | HTTP GET `/admin/articles` test |
| **Article Creation & Editing** | `Admin/ArticleController@create`, `@store`, `@edit`, `@update`, `@destroy` | Full article form with slug generation, status management, excerpt, SEO fields | **To Port in Stage D** | Jodit editor, real-time live preview | Form submission feature tests |
| **HTML Sanitizer Service** | `app/Services/HtmlSanitizerService.php` | DOMDocument-based XSS protection purging `<script>`, `<iframe>`, `on*` events | **To Port in Stage D** | `HtmlSanitizerService.php` | Unit test with XSS payloads |
| **Image Upload Service** | `app/Services/ImageUploadService.php`, `Admin/ArticleController@uploadImage` | Direct upload to `public/uploads/articles` with MIME check, SVG rejection, getimagesize | **To Port in Stage D** | Security validation, `.htaccess` execution block | Upload test with JPG and fake SVG |
| **AI Generation Workflow** | `app/Services/OllamaService.php`, `Admin/ArticleController@aiGenerate` | Ollama AI generator with structured JSON output, adapted for K3 Konstruksi | **To Port in Stage D** | Configurable Ollama service with K3 prompts | Unit test with mocked Ollama API |

---

## 5. Visual Identity & Styling Parity

| Feature | Reference Implementation | Target Implementation | Status |
| :--- | :--- | :--- | :--- |
| **Brand Colors** | Emerald `#059669` (P3K) | Navy `#0B192C`, Slate `#334155`/`#E2E8F0`, Safety Yellow `#FDB813` | **To Adapt in Stage E** |
| **Admin UI** | Generic soft emerald theme | Professional industrial construction safety dashboard | **To Adapt in Stage E** |
| **Public UI** | Clean medical emergency layout | High-contrast construction engineering layout | **To Adapt in Stage E** |

---

## Parity Verification Plan
1. **Migrations**: Run `add_is_admin_to_users_table` and `create_articles_table`.
2. **Commands**: Run `admin:create` command test.
3. **Automated Test Suite**: Run `phpunit` on unit and feature test suites.
4. **Vite Build**: Execute `npm run build` to verify frontend CSS/JS.
