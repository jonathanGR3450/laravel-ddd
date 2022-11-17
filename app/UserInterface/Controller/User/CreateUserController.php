<?php

namespace App\UserInterface\Controller\User;

use App\Application\User\CreateUserUseCase;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Laravel\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;

class CreateUserController extends Controller
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
        $createUserUsercase = new CreateUserUseCase($this->userRepositoryInterface);
        $user = $createUserUsercase->__invoke($request->input('name'), $request->input('email'), $request->input('password'));

        return Response::json([
            'data' => $user->asArray()
        ], JsonResponse::HTTP_CREATED);
    }
}
