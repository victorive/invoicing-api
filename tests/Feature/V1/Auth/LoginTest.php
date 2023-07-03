<?php

namespace Tests\Feature\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testUserCanLoginWithValidCredentials()
    {
        $response = $this->withHeader('Accept', 'application/json')
            ->postJson(route('login'), [
                'email' => $this->user->email,
                'password' => 'password'
            ]);

        $response->assertOk()->assertJson([
            'status' => true,
            'message' => 'Login successful',
        ])->assertHeader('Authorization',
            $response->headers->get('Authorization'));
    }

    public function testUserCannotLoginWithInvalidCredentials()
    {
        $response = $this->withHeader('Accept', 'application/json')
            ->postJson(route('login'), [
                'email' => $this->user->email,
                'password' => 'test1234'
            ])->assertUnprocessable()
            ->assertJson([
                'status' => false,
                'message' => 'Invalid email or password, please try again',
            ]);
    }
}
