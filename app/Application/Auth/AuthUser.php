<?php

declare(strict_types=1);

namespace App\Application\Auth;

use App\Application\Auth\Contracts\AuthUserInterface;
use App\Application\User\CreateUserUseCase;
use App\Domain\User\Aggregate\User;
use App\Domain\User\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

final class AuthUser implements AuthUserInterface
{
    private UserRepositoryInterface $userRepositoryInterface;
    private CreateUserUseCase $createUserUseCase;

    public function __construct(UserRepositoryInterface $userRepositoryInterface, CreateUserUseCase $createUserUseCase) {
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->createUserUseCase = $createUserUseCase;
    }
    
    public function loginCredentials(string $email, string $password): string
    {
        $credentials = compact('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                throw new UnauthorizedException('invalid_credentials');
            }
        } catch (JWTException $e) {
            throw new UnauthorizedException('could_not_create_token');
        }
        return $token;
    }

    public function loginUserModel(User $user): string
    {
        $user = $this->userRepositoryInterface->findByIdGetModel($user->id());
        $token = JWTAuth::fromUser($user);
        return $token;
    }

    public function getAuthUser(): \Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::user();
    }

    public function createUser(string $name, string $email, string $password): User
    {
        $user = $this->createUserUseCase->__invoke($name, $email, $password);
        return $user;
    }

    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function refresh(): string
    {
        return JWTAuth::refresh();
    }

    public function getAuthenticatedUser(): \Illuminate\Contracts\Auth\Authenticatable
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                throw new Exception('user_not_found', 401);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            throw new Exception('token_expired', 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            throw new Exception('token_invalid', 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            throw new Exception('token_absent', 401);
        }
        return $user;
    }
}
