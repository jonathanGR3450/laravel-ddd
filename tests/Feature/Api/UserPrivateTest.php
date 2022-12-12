<?php

namespace Tests\Feature\Api;

use App\Infrastructure\Laravel\Models\User;
use App\Infrastructure\Laravel\Models\Vinculation\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->user = User::factory()->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /** @test */
    public function logout()
    {
        $this->withHeader('Authorization', "Bearer {$this->token}");

        $response = $this->postJson(route('logout'));

        $response->assertExactJson([
            'status' => 'success',
            'message' => 'Successfully logged out'
        ])
        ->assertStatus(200);
    }

    /** @test */
    public function refresh()
    {
        $this->withHeader('Authorization', "Bearer {$this->token}");

        $response = $this->postJson(route('refresh'));

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'message', 'user', 'authorization']);
        $this->assertNotEquals($this->token, $response['authorization']['token']);
    }
}
