<?php declare(strict_types=1);

namespace App\Application\Auth\Contracts;

use App\Domain\User\Aggregate\User;

interface AuthUserInterface
{
    public function loginCredentials(string $email, string $password): string;

    public function loginUserModel(User $user): string;

    public function createUser(string $name, string $email, string $password): User;

    public function logout(): void;

    public function refresh(): string;

    public function getAuthUser(): \Illuminate\Contracts\Auth\Authenticatable;

    public function getAuthenticatedUser(): \Illuminate\Contracts\Auth\Authenticatable;
}