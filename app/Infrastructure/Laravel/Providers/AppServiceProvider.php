<?php

namespace App\Infrastructure\Laravel\Providers;

use App\Application\Auth\AuthUser;
use App\Application\Auth\Contracts\AuthUserInterface;
use App\Domain\Shared\ArchiveRepositoryInterface;
use App\Domain\Shared\CommentRepositoryInterface;
use App\Domain\Shared\DocumentRepositoryInterface;
use App\Domain\Shared\TypeProcessRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\Vinculation\BusinessRepositoryInterface;
use App\Domain\Vinculation\VinculationRepositoryInterface;
use App\Infrastructure\Shared\ArchiveRepository;
use App\Infrastructure\Shared\CommentRepository;
use App\Infrastructure\Shared\DocumentRepository;
use App\Infrastructure\Shared\TypeProcessRepository;
use App\Infrastructure\User\UserRepository;
use App\Infrastructure\Vinculation\BusinessRepository;
use App\Infrastructure\Vinculation\VinculationRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthUserInterface::class, AuthUser::class);
        $this->app->bind(BusinessRepositoryInterface::class, BusinessRepository::class);
        $this->app->bind(VinculationRepositoryInterface::class, VinculationRepository::class);
        $this->app->bind(TypeProcessRepositoryInterface::class, TypeProcessRepository::class);
        $this->app->bind(DocumentRepositoryInterface::class, DocumentRepository::class);
        $this->app->bind(ArchiveRepositoryInterface::class, ArchiveRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
