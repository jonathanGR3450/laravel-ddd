<?php

namespace Tests\Feature\Api\Vinculation;

use App\Infrastructure\Laravel\Models\Document;
use App\Infrastructure\Laravel\Models\User;
use App\Infrastructure\Laravel\Models\Vinculation\Business;
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

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();

        # make user, business, relationship and vinculation prosess
        $this->user = User::factory()->create();
        $this->business = Business::factory()->create();
        $this->vinculation = Process::factory()->create(['user_id' => $this->user->id, 'business_id' => $this->business->id]);

        $this->token = JWTAuth::fromUser($this->user);

        Session::put('business_id', $this->business->id);

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
        $data = ['file' => $this->file, 'document_id' => $this->document->id];

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
}
