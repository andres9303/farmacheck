<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Una prueba básica de ejemplo.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        // La aplicación redirige a /login
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
