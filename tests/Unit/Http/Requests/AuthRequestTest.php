<?php

namespace Tests\Unit\Http\Requests;

use App\Infrastructure\Laravel\Models\User;
use App\Infrastructure\Laravel\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class AuthRequestTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function login_email_required()
    {
        $this->withoutExceptionHandling();

        $validatedField = 'email';
        $brokenRule = null;

        $credentials = [$validatedField => $brokenRule];

        $response = $this->postJson(
            route('login'),
            $credentials
        );

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure(['success', 'message', 'errors']);
        $response->assertJsonValidationErrors($validatedField);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function login_business_required()
    {
        $this->withoutExceptionHandling();

        $validatedField = 'business_id';
        $brokenRule = null;

        $credentials = [$validatedField => $brokenRule];

        $response = $this->postJson(
            route('login'),
            $credentials
        );

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure(['success', 'message', 'errors']);
        $response->assertJsonValidationErrors($validatedField);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function login_email_invalidate()
    {
        $this->withoutExceptionHandling();

        $validatedField = 'email';
        $brokenRule = 'emailinvalid';

        $credentials = [$validatedField => $brokenRule];

        $response = $this->postJson(
            route('login'),
            $credentials
        );

        $response->assertUnprocessable();
        $response->assertJsonStructure(['success', 'message', 'errors']);
        $response->assertJsonValidationErrors($validatedField);
    }

    /** @test */
    public function register_with_errors_fields()
    {
        $user = User::factory()->make(['email' => 'email invalid', 'identification' => 'must be numeric', 'type_document_id' => 'id not exist', 'cell_phone' => 'must be numeric', 'is_manager' => 'must be boolean']);
        $business = Business::factory()->make(['email' => 'email invalid']);
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

        $response->assertJsonValidationErrors(['email', 'identification', 'type_document_id', 'cell_phone', 'is_manager', 'business_email']);
    }
}
