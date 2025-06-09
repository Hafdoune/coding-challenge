<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function homepage_loads_successfully()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
