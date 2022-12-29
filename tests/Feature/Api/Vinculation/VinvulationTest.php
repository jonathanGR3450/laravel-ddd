<?php

namespace Tests\Feature\Api\Vinculation;

use App\Infrastructure\Laravel\Models\Document;
use App\Infrastructure\Laravel\Models\User;
use App\Infrastructure\Laravel\Models\Vinculation\Business;
use App\Infrastructure\Laravel\Models\Vinculation\BusinessUser;
use App\Infrastructure\Laravel\Models\Vinculation\Process;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class VinvulationTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $business;
    private $vinculation;
    private $document;
    private $file;
    private $password;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();

        # make user, business, relationship and vinculation prosess
        $this->password = 'Lol123Lol@';
        $this->user = User::factory()->create();
        $this->business = Business::factory()->create();
        $this->vinculation = Process::factory()->create(['user_id' => $this->user->id, 'business_id' => $this->business->id]);
        BusinessUser::factory()->create(['user_id' => $this->user->id, 'business_id' => $this->business->id]);

        $credentials = [
            'email' => $this->user->email,
            'password' => $this->password,
            'business_id' => $this->business->id
        ];

        $response = $this->postJson(route('login'), $credentials);
        $this->token = $response['authorization']['token'];

        // documents avilable to vinculation process
        // "'cedula', 'camaracomercio', 'rut', 'declaracionrenta', 'estadosfinancieros', 'certificacionbancaria', 'composicionaccionaria'"
        $sizeInKilobytes = 10;
        $this->document = Document::where('name', 'declaracionrenta')->get()->first();
        Storage::fake('local');
        $this->file = UploadedFile::fake()->create(
            'document.pdf',
            $sizeInKilobytes,
            'application/pdf'
        );
    }

    /** @test */
    public function upload_document()
    {
        $this->withHeader('Authorization', "Bearer {$this->token}");
        $data = [
            'file' => $this->file,
            'document_id' => $this->document->id,
            'business_id' => $this->business->id
        ];

        $response = $this->postJson(route('vinculation.upload'), $data);

        $response->assertCreated();
        $response->assertJsonStructure(['status', 'message', 'data']);

        Storage::disk('local')->assertExists($response['data']['path'] . $response['data']['name_now']);
    }

    /** @test */
    public function upload_document_unauthorized()
    {
        $data = ['file' => $this->file, 'document_id' => $this->document->id];

        $response = $this->postJson(route('vinculation.upload'), $data);

        $response->assertUnauthorized();
    }

    /** @test */
    public function upload_document_business_no_belog_to_user()
    {
        $business = Business::factory()->create();
        $this->withHeader('Authorization', "Bearer {$this->token}");
        $data = [
            'file' => $this->file,
            'document_id' => $this->document->id,
            'business_id' => $business->id
        ];

        $response = $this->postJson(route('vinculation.upload'), $data);

        $response->assertUnauthorized();
        $response->assertExactJson([
            'status' => 'error',
            'message' => 'Business not belog to user'
        ]);
    }
}
