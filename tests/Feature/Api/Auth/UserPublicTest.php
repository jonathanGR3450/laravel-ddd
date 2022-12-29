<?php

namespace Tests\Feature\Api\Auth;

use App\Infrastructure\Laravel\Models\User;
use App\Infrastructure\Laravel\Models\Business;
use App\Infrastructure\Laravel\Models\BusinessUser;
use App\Infrastructure\Laravel\Models\Process;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class UserPublicTest extends TestCase
{
    use RefreshDatabase;

    private $password;
    private $user;
    private $business;


    public function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->password = 'Lol123Lol@';
        $this->user = User::factory()->create(['password' => Hash::make($this->password)]);
        $this->business = Business::factory()->create();

        BusinessUser::factory()->create(['user_id' => $this->user->id, 'business_id' => $this->business->id]);
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
        $credentials = [
            'email' => $this->user->email,
            'password' => $this->password,
            'business_id' => $this->business->id
        ];

        $response = $this->postJson(route('login'), $credentials);
        $response->json();

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'message', 'user', 'business', 'authorization']);
        $this->assertTrue(Auth::check());
    }

    /** @test */
    public function login_business_not_belong_to_user_auth()
    {
        $business = Business::factory()->create();
        $credentials = [
            'email' => $this->user->email,
            'password' => $this->password,
            'business_id' => $business->id
        ];

        $response = $this->postJson(route('login'), $credentials);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST)
            ->assertExactJson([
                'status' => 'error',
                'message' => 'La empresa seleccionada no pertenece al usuario',
            ]);
    }

    /**
     * @test
     */
    public function login_credentials_invalid()
    {
        $this->withoutExceptionHandling();

        $validatedField = 'email';
        $brokenRule = 'test@test.com';
        $validatedField1 = 'password';
        $brokenRule1 = 'secret';

        $validatedField2 = 'business_id';
        $brokenRule2 = $this->business->id;

        $credentials = [$validatedField => $brokenRule, $validatedField1 => $brokenRule1, $validatedField2 => $brokenRule2];

        $response = $this->postJson(
            route('login'),
            $credentials
        );

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => 'Unauthorized'
        ]);
    }

    /** @test */
    public function refresh_without_token()
    {
        $response = $this->postJson(route('refresh'));

        $response->assertExactJson([
            'status' => 'error',
            "message" => "Authorization Token not found"
        ]);

        $response->assertUnauthorized();
    }

    /** @test */
    public function refresh_with_invalid()
    {
        $token_fake = "token_invalid";
        $this->withHeader("Authorization", "Bearer {$token_fake}");

        $response = $this->postJson(route('refresh'));

        $response->assertExactJson([
            "status" => "error",
            "message" => "Token is Invalid"
        ]);
        $response->assertUnauthorized();
    }
}
