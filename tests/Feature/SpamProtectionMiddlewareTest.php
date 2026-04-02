<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class SpamProtectionMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer une route de test avec le middleware spam.protection
        Route::middleware(['web', 'spam.protection'])->group(function () {
            Route::post('/test-spam-protection', function () {
                return response()->json(['message' => 'Request passed']);
            })->name('test.spam');
        });
    }

    /**
     * Test que les requêtes légitimes passent le middleware
     */
    public function test_legitimate_request_passes_middleware(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'timestamp' => now()->timestamp,
            'website' => '', // honeypot vide
        ];

        $response = $this->post('/test-spam-protection', $data);

        $response->assertStatus(200)
                ->assertJson(['message' => 'Request passed']);
    }

    /**
     * Test que le honeypot remplit bloque la requête
     */
    public function test_honeypot_field_blocks_request(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'timestamp' => now()->timestamp,
            'website' => 'http://spam-site.com', // honeypot remplit
        ];

        $response = $this->post('/test-spam-protection', $data);

        $response->assertStatus(403)
                ->assertJson(['error' => 'Spam detected']);
    }

    /**
     * Test que les requêtes trop rapides sont bloquées
     */
    public function test_fast_request_blocks_spam(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'timestamp' => now()->subSeconds(1)->timestamp, // trop rapide
            'website' => '',
        ];

        $response = $this->post('/test-spam-protection', $data);

        $response->assertStatus(403)
                ->assertJson(['error' => 'Request too fast']);
    }

    /**
     * Test que les patterns suspects sont détectés
     */
    public function test_suspicious_patterns_are_blocked(): void
    {
        $data = [
            'name' => 'John Doe<script>alert("xss")</script>',
            'email' => 'john@example.com',
            'timestamp' => now()->timestamp,
            'website' => '',
        ];

        $response = $this->post('/test-spam-protection', $data);

        $response->assertStatus(403)
                ->assertJson(['error' => 'Suspicious content detected']);
    }

    /**
     * Test que les données JavaScript sont bloquées
     */
    public function test_javascript_injection_is_blocked(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'javascript:alert("xss")',
            'timestamp' => now()->timestamp,
            'website' => '',
        ];

        $response = $this->post('/test-spam-protection', $data);

        $response->assertStatus(403)
                ->assertJson(['error' => 'Suspicious content detected']);
    }
}
