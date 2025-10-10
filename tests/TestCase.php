<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Configura el idioma español para todos los tests
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Establecer el idioma español para todos los tests
        $this->app->setLocale('es');
    }
}
