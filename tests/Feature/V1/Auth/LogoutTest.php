<?php

namespace Tests\Feature\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
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
        $this->actingAs($this->user)
            ->post(route('logout'))
            ->assertOk()
            ->assertJson([
                'status' => true,
                'message' => 'Logout successful',
            ]);
    }
}
