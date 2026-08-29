<?php
namespace App\Jobs;

use PDO;
use Throwable;

/**
 * SeoContentGeneratorJob — Organic Content Engine & Semantic SEO Moat
 * Generates Category Buyer's Guides, Comparison Guides, and Schema.org FAQ Microdata
 * to establish organic search compounding traffic.
 */
class SeoContentGeneratorJob
{
    private PDO $pdo;
    private int $store_id;

    public function __construct(PDO $pdo, int $store_id = 1)
    {
        $this->pdo = $pdo;
        $this->store_id = $store_id;
    }

    public function handle(array $payload = []): bool
    {
        $collection_id = (int)($payload['collection_id'] ?? 0);

        // Fetch collections
        if ($collection_id) {
            $stmt_col = $this->pdo->prepare("SELECT * FROM collections WHERE id = ?");
            $stmt_col->execute([$collection_id]);
        } else {
            $stmt_col = $this->pdo->prepare("SELECT * FROM collections WHERE is_active = 1 LIMIT 3");
            $stmt_col->execute();
        }
        $collections = $stmt_col->fetchAll();

        foreach ($collections as $col) {
            $col_title = $col['title'];
            $col_slug = $col['slug'];

            // Fetch Top Products in this collection
            $stmt_prods = $this->pdo->prepare("
                SELECT id, title, base_price, description FROM products 
                WHERE collection_id = ? AND status = 'active' 
                LIMIT 5
            ");
            $stmt_prods->execute([$col['id']]);
            $prods = $stmt_prods->fetchAll();

            $article_title = "The Ultimate 2026 Buyer's Guide to $col_title: Ergonomics, Durability & Performance";
            $article_slug = 'buyers-guide-' . $col_slug . '-2026';

            // 1. Build Comprehensive Buyer's Guide Narrative
            $body_html = "<div class='seo-buyers-guide'>";
            $body_html .= "<h2>Why Quality Matters in $col_title</h2>";
            $body_html .= "<p>Choosing the right gear isn't just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p>";
            
            $body_html .= "<h3>Top Recommended Options:</h3><div class='product-comparison-grid'>";
            foreach ($prods as $p) {
                $body_html .= "<div class='comparison-item'>";
                $body_html .= "<h4>" . htmlspecialchars($p['title']) . " (₹" . number_format($p['base_price'], 2) . ")</h4>";
                $body_html .= "<p>" . htmlspecialchars(substr(strip_tags($p['description']), 0, 140)) . "...</p>";
                $body_html .= "</div>";
            }
            $body_html .= "</div>";

            // 2. Build Schema.org FAQ Microdata
            $faq_schema = [
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => [
                    [
                        '@type'          => 'Question',
                        'name'           => "What warranty is included with NovaDrop $col_title products?",
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => "Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee."
                        ]
                    ],
                    [
                        '@type'          => 'Question',
                        'name'           => "How fast is shipping across India?",
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => "Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3–5 business days."
                        ]
                    ]
                ]
            ];

            $body_html .= "<h3>Frequently Asked Questions</h3>";
            $body_html .= "<div class='faq-accordion'><div class='faq-q'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div>";
            $body_html .= "<script type='application/ld+json'>" . json_encode($faq_schema, JSON_UNESCAPED_SLASHES) . "</script>";
            $body_html .= "</div>";

            // 3. Record Generated Article to ai_agent_tasks & store_pages / blog
            $this->pdo->prepare("
                INSERT INTO ai_agent_tasks (store_id, agent, input_json, output_text, status, created_at)
                VALUES (?, 'seo_content_generator', ?, ?, 'done', NOW())
            ")->execute([
                $this->store_id,
                json_encode([
                    'collection' => $col_title,
                    'slug'       => $article_slug,
                    'title'      => $article_title,
                    'schema'     => $faq_schema
                ]),
                $body_html
            ]);
        }

        return true;
    }
}
