<?php

namespace Tests\Feature\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    private array $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->raw();
        $this->user['password_confirmation'] = 'password';
    }

    public function testUserCanRegisterWithValidCredentials()
    {
        $this->withHeader('Accept', 'application/json')
            ->postJson(route('register'), $this->user)
            ->assertCreated()
            ->assertJson([
                'status' => true,
                'message' => 'Registration successful',
            ]);

        $this->assertDatabaseHas('users', ['email' => $this->user['email']]);
    }

    public function testUserCannotRegisterMoreThanOnceWithSameCredentials()
    {
        $this->withHeader('Accept', 'application/json')
            ->postJson(route('register'), $this->user);

        $this->withHeader('Accept', 'application/json')
            ->postJson(route('register'), $this->user)
            ->assertUnprocessable()
            ->assertSee([
                'message' => 'The email has already been taken'
            ]);
    }

    public function testUserCannotRegisterWithInvalidCredentials()
    {
        $this->withHeader('Accept', 'application/json')
            ->postJson(route('register'), [
                'name' => '',
                'email' => 'email',
                'password' => '',
                'phone' => 'phone',
                'address_line_1' => '',
                'address_line_2' => '',
                'postal_code' => '',
                'city' => '',
                'state' => '',
                'country' => '',
                'website' => 'website'
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name', 'email', 'password', 'phone',
                'address_line_1', 'address_line_2',
                'postal_code', 'city', 'state',
                'country', 'website'
            ]);
    }
}
