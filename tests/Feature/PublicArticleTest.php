<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicArticleTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(bool $isAdmin = false): User
    {
        return User::factory()->create(['is_admin' => $isAdmin]);
    }

    private function publishedArticle(array $overrides = []): Article
    {
        return Article::create(array_merge([
            'title'        => 'Penerapan SMKK dalam Proyek Konstruksi',
            'slug'         => 'penerapan-smkk-proyek-konstruksi',
            'excerpt'      => 'Sistem Manajemen Keselamatan Konstruksi wajib diterapkan.',
            'content'      => '<p>Konten artikel edukasi K3 Konstruksi.</p>',
            'status'       => 'published',
            'published_at' => now()->subDay(),
        ], $overrides));
    }

    private function draftArticle(array $overrides = []): Article
    {
        return Article::create(array_merge([
            'title'   => 'Draft: RKK Proyek Jembatan',
            'slug'    => 'draft-rkk-proyek-jembatan',
            'content' => '<p>Draft tidak boleh terlihat publik.</p>',
            'status'  => 'draft',
        ], $overrides));
    }

    // ─── Index Tests ──────────────────────────────────────────────────────────

    public function test_article_index_loads(): void
    {
        $this->get(route('articles.index'))
            ->assertOk()
            ->assertSee('Artikel');
    }

    public function test_article_index_shows_published_articles(): void
    {
        $article = $this->publishedArticle();

        $this->get(route('articles.index'))
            ->assertOk()
            ->assertSee($article->title);
    }

    public function test_article_index_does_not_show_drafts(): void
    {
        $draft = $this->draftArticle();

        $this->get(route('articles.index'))
            ->assertOk()
            ->assertDontSee($draft->title);
    }

    public function test_article_index_shows_program_links(): void
    {
        $response = $this->get(route('articles.index'));
        $response->assertOk();
        $response->assertSee(route('program.show', 'training-plb3'));
        $response->assertSee(route('program.show', 'training-pppa'));
    }

    // ─── Show Tests ───────────────────────────────────────────────────────────

    public function test_article_show_loads_for_published(): void
    {
        $article = $this->publishedArticle();

        $this->get(route('articles.show', $article->slug))
            ->assertOk()
            ->assertSee($article->title);
    }

    public function test_article_show_returns_404_for_draft(): void
    {
        $draft = $this->draftArticle();

        $this->get(route('articles.show', $draft->slug))
            ->assertNotFound();
    }

    public function test_article_show_returns_404_for_unknown_slug(): void
    {
        $this->get(route('articles.show', 'tidak-ada-artikel-ini'))
            ->assertNotFound();
    }

    public function test_article_show_contains_seo_metadata(): void
    {
        $article = $this->publishedArticle([
            'seo_title'        => 'SEO Title K3 Konstruksi Khusus',
            'meta_description' => 'Deskripsi meta khusus artikel K3.',
        ]);

        $response = $this->get(route('articles.show', $article->slug));
        $response->assertOk();
        $response->assertSee('SEO Title K3 Konstruksi Khusus');
        $response->assertSee('Deskripsi meta khusus artikel K3.');
    }

    public function test_article_show_contains_breadcrumbs(): void
    {
        $article = $this->publishedArticle();

        $response = $this->get(route('articles.show', $article->slug));
        $response->assertOk();
        $response->assertSee('Beranda');
        $response->assertSee('Artikel');
        $response->assertSee($article->title);
    }

    public function test_article_show_renders_faq_section(): void
    {
        $article = $this->publishedArticle([
            'faqs' => [
                ['q' => 'Apa itu K3 Konstruksi Muda?', 'a' => 'Sertifikasi tingkat dasar untuk pekerja konstruksi.'],
            ],
        ]);

        $response = $this->get(route('articles.show', $article->slug));
        $response->assertOk();
        $response->assertSee('Pertanyaan Umum');
        $response->assertSee('Apa itu K3 Konstruksi Muda?');
    }

    public function test_article_show_does_not_leak_image_brief(): void
    {
        $article = $this->publishedArticle([
            'image_brief' => [
                'concept'         => 'Secret AI concept brief here',
                'english_prompt'  => 'Construction workers in safety helmets, photorealistic',
                'recommended_alt' => 'Workers in K3 gear',
            ],
        ]);

        $response = $this->get(route('articles.show', $article->slug));
        $response->assertOk();
        $response->assertDontSee('Secret AI concept brief here');
        $response->assertDontSee('english_prompt');
    }

    public function test_article_show_contains_whatsapp_cta(): void
    {
        $article = $this->publishedArticle();

        $response = $this->get(route('articles.show', $article->slug));
        $response->assertOk();
        $response->assertSee('wa.me', false);
    }

    public function test_article_show_contains_article_schema(): void
    {
        $article = $this->publishedArticle();

        $response = $this->get(route('articles.show', $article->slug));
        $response->assertOk();
        $response->assertSee('application/ld+json', false);
        $response->assertSee('Article', false);
    }
}
