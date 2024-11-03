<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test login.
     */
    public function LoginTest(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
