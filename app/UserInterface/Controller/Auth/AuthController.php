<?php

namespace App\UserInterface\Controller\Auth;

use App\Application\Auth\Contracts\AuthUserInterface;
use App\Application\Vinculation\CreateBusinessUseCase;
use App\Application\Vinculation\CreateBusinessUserUseCase;
use App\Application\Vinculation\CreateVinculationUseCase;
use App\Infrastructure\Laravel\Controller;
use App\UserInterface\Requests\Auth\LoginFormRequest;
use App\UserInterface\Requests\Auth\RegisterFormRequest;
use Exception;
use Illuminate\Http\JsonResponse;
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
            $user = $this->authUserInterface->getAuthUserAgreggate();
            $userBelongToBusiness = $this->authUserInterface->userBelongToBusiness($request->business_id);

            if (!$userBelongToBusiness) {
                throw new Exception("La empresa seleccionada no pertenece al usuario", JsonResponse::HTTP_BAD_REQUEST);
            }
            $business = $this->authUserInterface->getBusinessById($request->business_id);
            return response()->json([
                'status' => 'success',
                'message' => 'User logged successfully',
                'user' => $user->asArray(),
                'business' => $business->asArray(),
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ], 200);
        } catch (UnauthorizedException $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], empty($e->getCode()) ? 500 : $e->getCode());
        }
    }


    public function register(RegisterFormRequest $request, CreateBusinessUseCase $createBusinessUseCase, CreateVinculationUseCase $createVinculationUseCase, CreateBusinessUserUseCase $createBusinessUserUseCase)
    {
        // dd($request->all(), $request->input('last_name'));
        $user = $this->authUserInterface->createUser(
            $request->input('name'),
            $request->input('last_name'),
            $request->input('email'),
            $request->input('identification'),
            $request->input('type_document_id'),
            $request->input('cell_phone'),
            $request->input('city'),
            $request->input('address'),
            $request->input('city_register'),
            (bool) $request->input('is_manager'),
            (bool) $request->input('is_signer'),
            $request->input('is_verified'),
            $request->input('password')
        );
        $business = $createBusinessUseCase->__invoke(
            $request->input('business_name'),
            $request->input('phone'),
            $request->input('nit'),
            $request->input('business_address'),
            $request->input('department'),
            $request->input('business_city'),
            $request->input('type_person'),
            $request->input('business_email'),
            $request->input('business_city_register')
        );
        $createBusinessUserUseCase->__invoke($business, $user);
        $vinculation = $createVinculationUseCase->__invoke($user->id()->value(), $business->id()->value());
        $token = $this->authUserInterface->loginUserModel($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user->asArray(),
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], JsonResponse::HTTP_CREATED);
    }

    public function logout()
    {
        $this->authUserInterface->logout();

        $this->authUserInterface->removeBusinessSession();
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
        try {
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully refresh token',
                'user' => $this->authUserInterface->getAuthenticatedUser(),
                'authorization' => [
                    'token' => $this->authUserInterface->refresh(),
                    'type' => 'bearer',
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }
}
