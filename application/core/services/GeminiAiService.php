<?php
namespace App\Services;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop Gemini AI Integration Service
 * Powers live AI copywriting, SEO metadata generation, Ad Studio copy, and Email Campaigns.
 */
class GeminiAiService
{
    private string $apiKey;
    private string $model;
    private int $timeout;

    public function __construct(?string $apiKey = null, string $model = 'gemini-1.5-flash', int $timeout = 15)
    {
        $this->apiKey  = $apiKey ?: (string)(getenv('GEMINI_API_KEY') ?: env('GEMINI_API_KEY', ''));
        $this->model   = (string)(getenv('GEMINI_MODEL') ?: env('GEMINI_MODEL', $model));
        $this->timeout = $timeout;
    }

    /**
     * Send prompt to Google Gemini Generative Language API
     */
    public function generate(string $prompt, float $temperature = 0.7): ?string
    {
        if (empty($this->apiKey) || $this->apiKey === 'REPLACE_ME') {
            if (function_exists('log_message')) { \log_message('debug', 'GeminiAiService: GEMINI_API_KEY is not configured in .env'); }
            return null;
        }

        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature'     => $temperature,
                'maxOutputTokens' => 1200,
            ]
        ];

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError || $httpCode !== 200) {
            if (function_exists('log_message')) { \log_message('error', "GeminiAiService API Error (HTTP {$httpCode}): " . ($curlError ?: $response)); }
            return null;
        }

        $data = json_decode($response, true);
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
        return $text ? trim($text) : null;
    }

    /**
     * Generate High-Converting E-Commerce Product Copywriting
     */
    public function generate_product_copy(string $title, string $specs = '', string $tone = 'Architectural Luxury'): array
    {
        $prompt = "You are an elite e-commerce creative director for NovaDrop Haute Couture & Performance Dropshipping.
Write compelling, high-converting product description for:
Product: {$title}
Specifications/Details: {$specs}
Tone: {$tone}

Respond ONLY with valid JSON in this exact structure:
{
  \"title\": \"Polished Editorial Title\",
  \"short_description\": \"Punchy 1-2 sentence hook highlighting craftsmanship, materials, and benefits.\",
  \"full_description\": \"Rich 2-paragraph editorial description detailing materials, tailoring, and lifestyle utility.\",
  \"highlights\": [\"Feature 1\", \"Feature 2\", \"Feature 3\", \"Feature 4\"],
  \"seo_title\": \"SEO Meta Title (max 60 chars)\",
  \"seo_description\": \"SEO Meta Description with Call to Action (max 155 chars)\"
}";

        $aiText = $this->generate($prompt, 0.6);
        if ($aiText) {
            // Clean markdown code fence if present
            $cleaned = preg_replace('/^```(?:json)?\s*|\s*```$/i', '', trim($aiText));
            $json = json_decode($cleaned, true);
            if (is_array($json) && !empty($json['short_description'])) {
                return [
                    'success' => true,
                    'source'  => 'gemini-live',
                    'data'    => $json
                ];
            }
        }

        // High-Quality Fallback
        return [
            'success' => true,
            'source'  => 'editorial-template',
            'data'    => [
                'title'             => $title,
                'short_description' => "Crafted with precision engineering and heirloom-grade textiles, {$title} delivers effortless sophistication and everyday utility.",
                'full_description'  => "Designed for the discerning minimalist, {$title} pairs architectural silhouette with uncompromising material integrity. Every seam is finished to atelier standards, ensuring durability, comfort, and enduring elegance across seasons.\n\nWhether styled for formal occasions or relaxed daily wear, this piece balances tactile luxury with functional modern performance.",
                'highlights'        => [
                    "Master-tailored construction with reinforced stitching",
                    "Breathable, high-density premium textile composition",
                    "Ergonomic tailored fit engineered for all-day comfort",
                    "Complimentary insured white-glove express delivery"
                ],
                'seo_title'         => substr("{$title} | Luxury Edition — NovaDrop", 0, 60),
                'seo_description'   => substr("Shop {$title} online at NovaDrop. Handcrafted luxury, premium materials & complimentary insured shipping.", 0, 155),
            ]
        ];
    }

    /**
     * Generate Meta & Google Ads Copywriting
     */
    public function generate_ad_copy(string $productTitle, string $platform = 'meta', string $angle = 'scarcity'): array
    {
        $prompt = "Create high-converting {$platform} advertising copy for NovaDrop e-commerce.
Product: {$productTitle}
Angle/Hook: {$angle}

Respond ONLY with valid JSON:
{
  \"headline\": \"Attention-grabbing Headline\",
  \"primary_text\": \"Compelling body copy addressing problem, transformation, and offer.\",
  \"description\": \"Supporting one-liner link description\",
  \"cta\": \"Shop Now\",
  \"hooks\": [\"Hook 1\", \"Hook 2\", \"Hook 3\"],
  \"suggested_audiences\": [\"Audience 1\", \"Audience 2\"]
}";

        $aiText = $this->generate($prompt, 0.7);
        if ($aiText) {
            $cleaned = preg_replace('/^```(?:json)?\s*|\s*```$/i', '', trim($aiText));
            $json = json_decode($cleaned, true);
            if (is_array($json) && !empty($json['headline'])) {
                return ['success' => true, 'source' => 'gemini-live', 'data' => $json];
            }
        }

        return [
            'success' => true,
            'source'  => 'editorial-template',
            'data'    => [
                'headline'            => "Experience Unrivaled Craftsmanship: {$productTitle}",
                'primary_text'        => "Tired of mass-produced compromise? Discover {$productTitle} — engineered from virgin raw materials with obsessive attention to detail. Order today and enjoy complimentary insured express delivery.",
                'description'         => "Limited Atelier Batch · 100% Satisfaction Guaranteed",
                'cta'                 => "Claim Yours Now",
                'hooks'               => [
                    "The missing piece in your luxury capsule collection.",
                    "Why 1,500+ connoisseurs upgraded this season.",
                    "Rare materials. Uncompromising design."
                ],
                'suggested_audiences' => ["Luxury Fashion Enthusiasts", "High-Net-Worth Online Shoppers", "Minimalist Lifestyle"]
            ]
        ];
    }
}
