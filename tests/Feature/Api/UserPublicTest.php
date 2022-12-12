<?php

namespace Tests\Feature\Api;

use App\Infrastructure\Laravel\Models\User;
use App\Infrastructure\Laravel\Models\Vinculation\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserPublicTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function register()
    {
        $user = User::factory()->make();
        $business = Business::factory()->make();
        $data = [
            "name" => $user->name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "identification" => $user->identification,
            "type_document_id" => $user->type_document_id,
            "cell_phone" => $user->cell_phone,
            "city" => $user->city,
            "address" => $user->address,
            "city_register" => $user->city_register,
            "is_manager" => $user->is_manager,
            "is_signer" => $user->is_signer,
            "is_verified" => $user->is_verified,
            "password" => "Lol123Lol@",
            "password_confirmation" => "Lol123Lol@",
            "business_name" => $business->business_name,
            "phone" => $business->phone,
            "nit" => $business->nit,
            "business_address" => $business->address,
            "department" => $business->department,
            "business_city" => $business->city,
            "type_person" => $business->type_person,
            "business_email" => $business->email,
            "business_city_register" => $business->city_register,
        ];

        $response = $this->postJson(route('register'), $data);

        $response->assertCreated();
        $response->assertJsonStructure(['status', 'message', 'user', 'authorization']);
        $this->assertDatabaseHas(
            'users',
            $user->makeHidden(['id'])->toArray()
        );

        $this->assertDatabaseHas(
            'business',
            $business->makeHidden(['id'])->toArray()
        );
    }

    /** @test */
    public function login()
    {
        $user = User::factory()->create();
        $credentials = [
            'email' => $user->email,
            'password' => 'Lol123Lol@'
        ];

        $response = $this->postJson(route('login'), $credentials);

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'message', 'user', 'authorization']);
        $this->assertTrue(Auth::check());
    }
}
