<?php

namespace App\UserInterface\Controller\Vinculation;

use App\Application\Auth\Contracts\AuthUserInterface;
use App\Application\Shared\CreateArchiveUseCase;
use App\Application\Shared\CreateCommentUseCase;
use App\Domain\Shared\DocumentRepositoryInterface;
use App\Domain\Shared\ValueObjects\Id;
use App\Infrastructure\Laravel\Controller;
use App\Infrastructure\Laravel\Models\Document;
use App\Infrastructure\Laravel\Models\Archive;
use App\Infrastructure\Laravel\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UploadFileFactorOrFiduciaryController extends Controller
{
    private CreateArchiveUseCase $createArchiveUseCase;
    private CreateCommentUseCase $createCommentUseCase;

    public function __construct(CreateArchiveUseCase $createArchiveUseCase, CreateCommentUseCase $createCommentUseCase) {
        $this->createArchiveUseCase = $createArchiveUseCase;
        $this->createCommentUseCase = $createCommentUseCase;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // create file
        try {
            $path = 'documents/';
            $typeProcess = 'vinculacion';

            $archive = $this->createArchiveUseCase->__invoke(
                $request->document_id,
                $request->file->getClientMimeType(),
                $path,
                $request->file->getClientOriginalName(),
                $request->file->getClientOriginalExtension(),
                $request->business_id,
                $request->file,
                $typeProcess
            );

            $comment = $this->createCommentUseCase->__invoke(
                $request->observation,
                $archive->processId()->value(),
                $request->state,
            );

            return Response::json([
                'status' => 'success',
                'message' => 'File Create Successfully',
                'data' => [
                    'archive' => $archive->asArray(),
                    'comment' => $comment->asArray()
                ]
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
