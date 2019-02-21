<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APITest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();
        $this->email = str_random(10) . '@demo.com';
        $this->password = '12345';
    }

    /**
     * create user using the api '/api/register' endpoint
     */
    public function testUserCreation()
    {
        $response = $this->json('POST', '/api/register', [
            'name' => 'Demo User',
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'success' => ['token', 'name']
        ]);
    }

    /**
     * get access token for user using the api '/api/login' endpoint
     */
    public function testUserLogin()
    {
        $response = $this->json('POST', '/api/login', [
            'email' => $this->email,
            'password' => $this->password
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'success' => ['token']
        ]);
    }
}
