<?php

namespace App\UserInterface\Controller\Vinculation;

use App\Application\Auth\Contracts\AuthUserInterface;
use App\Application\Shared\CreateArchiveUseCase;
use App\Domain\Shared\DocumentRepositoryInterface;
use App\Domain\Shared\ValueObjects\Id;
use App\Infrastructure\Laravel\Controller;
use App\Infrastructure\Laravel\Models\Document;
use App\Infrastructure\Laravel\Models\Vinculation\Archive;
use App\Infrastructure\Laravel\Models\Vinculation\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    private AuthUserInterface $authUserInterface;
    private CreateArchiveUseCase $createArchiveUseCase;

    public function __construct(AuthUserInterface $authUserInterface, CreateArchiveUseCase $createArchiveUseCase) {
        $this->authUserInterface = $authUserInterface;
        $this->createArchiveUseCase = $createArchiveUseCase;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // create file
        dd(Auth::user());
        try {
            $business = $this->authUserInterface->getBusinessSession();
            $path = 'documents/';
            $archive = $this->createArchiveUseCase->__invoke(
                $request->document_id,
                $request->file->getClientMimeType(),
                $path,
                $request->file->getClientOriginalName(),
                $request->file->getClientOriginalExtension(),
                $business,
                $request->file
            );

            return Response::json([
                'status' => 'success',
                'message' => 'File Create Successfully',
                'data' => $archive->asArray()
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            return Response::json([
                'status' => 'error',
                'message' => 'File Create error',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
