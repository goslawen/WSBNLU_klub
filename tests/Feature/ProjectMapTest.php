<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectMapTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_map_page_works(): void
    {
        $response = $this->get('/project-map');

        $response->assertOk();
        $response->assertSee('Mapa projektu');
    }
}