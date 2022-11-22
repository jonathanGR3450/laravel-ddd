<?php

namespace App\UserInterface\Controller\Auth;

use App\Application\Auth\Contracts\AuthUserInterface;
use App\Infrastructure\Laravel\Controller;
use App\UserInterface\Requests\Auth\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller
{
    private AuthUserInterface $authUserInterface;
    public function __construct(AuthUserInterface $authUserInterface)
    {
        $this->middleware('jwt.verify', ['except' => ['login','register']]);
        $this->authUserInterface = $authUserInterface;
    }

    public function login(LoginFormRequest $request)
    {
        try {
            $token = $this->authUserInterface->loginCredentials($request->input('email'), $request->input('password'));
            $user = $this->authUserInterface->getAuthUser();
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ], 200);
        } catch (UnauthorizedException $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function register(Request $request)
    {
        $user = $this->authUserInterface->createUser($request->input('name'), $request->input('email'), $request->input('password'));
        $token = $this->authUserInterface->loginUserModel($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user->asArray(),
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        $this->authUserInterface->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function getAuthenticatedUser()
    {
        $user = $this->authUserInterface->getAuthUser();
        return response()->json(compact('user'));
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => $this->authUserInterface->getAuthenticatedUser(),
            'authorization' => [
                'token' => $this->authUserInterface->refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
