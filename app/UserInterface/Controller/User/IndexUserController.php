<?php

namespace App\UserInterface\Controller\User;

use App\Application\User\IndexUserUseCase;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Laravel\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;

class IndexUserController extends Controller
{
    private UserRepositoryInterface $userRepositoryInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface) {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // dd($request->all());
        $indexUserUseCase = new IndexUserUseCase($this->userRepositoryInterface);
        $users = $indexUserUseCase->__invoke(
            (int) $request->query('offset'),
            $request->query('email'),
            $request->query('name'),
        );

        return Response::json([
            'data' => $users
        ], JsonResponse::HTTP_CREATED);
    }
}
