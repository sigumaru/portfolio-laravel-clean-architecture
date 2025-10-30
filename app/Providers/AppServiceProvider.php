<?php

namespace App\Providers;

use App\Application\Contracts\Interactors\Blog\CreateBlogPostInteractorInterface;
use App\Application\Contracts\Interactors\Blog\DeleteBlogPostInteractorInterface;
use App\Application\Contracts\Interactors\Blog\GetBlogPostsInteractorInterface;
use App\Application\Contracts\Interactors\Blog\UpdateBlogPostInteractorInterface;
use App\Application\Contracts\Interactors\Contact\SendContactInteractorInterface;
use App\Application\Contracts\Interactors\Profile\UpdateProfileInteractorInterface;
use Illuminate\Support\ServiceProvider;

// Domain Repository Interfaces
use App\Domain\Repositories\BlogPostRepositoryInterface;
use App\Domain\Repositories\ContactRepositoryInterface;
use App\Domain\Repositories\ProfileRepositoryInterface;

// Infrastructure Repository Implementations
use App\Infrastructure\Repositories\EloquentBlogPostRepository;
use App\Infrastructure\Repositories\EloquentContactRepository;
use App\Infrastructure\Repositories\EloquentProfileRepository;

// Application Presenter Interfaces
use App\Application\Contracts\Presenters\BlogPresenterInterface;
use App\Application\Contracts\Presenters\ContactPresenterInterface;
use App\Application\Contracts\Presenters\ProfilePresenterInterface;

// Presentation Presenter Implementations
use App\Presentation\Http\Presenters\WebBlogPresenter;
use App\Presentation\Http\Presenters\WebContactPresenter;
use App\Presentation\Http\Presenters\WebProfilePresenter;

// Application Service Interfaces
use App\Application\Contracts\Services\MailServiceInterface;
use App\Application\Interactors\Blog\CreateBlogPostInteractor;
use App\Application\Interactors\Blog\DeleteBlogPostInteractor;
use App\Application\Interactors\Blog\GetBlogPostsInteractor;
use App\Application\Interactors\Blog\UpdateBlogPostInteractor;
use App\Application\Interactors\Contact\SendContactInteractor;
use App\Application\Interactors\Profile\UpdateProfileInteractor;
// Infrastructure Service Implementations
use App\Infrastructure\Services\LaravelMailService;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->registerBlogInteractors();
        $this->registerContactInteractors();
        $this->registerProfileInteractors();
    }

    public function registerBlogInteractors(): void
    {
        // Repository bindings
        $this->app->bind(
            BlogPostRepositoryInterface::class,
            EloquentBlogPostRepository::class
        );

        $this->app->bind(
            ContactRepositoryInterface::class,
            EloquentContactRepository::class
        );

        $this->app->bind(
            ProfileRepositoryInterface::class,
            EloquentProfileRepository::class
        );

        // Presenter bindings
        $this->app->bind(
            BlogPresenterInterface::class,
            WebBlogPresenter::class
        );

        $this->app->bind(
            ContactPresenterInterface::class,
            WebContactPresenter::class
        );

        $this->app->bind(
            ProfilePresenterInterface::class,
            WebProfilePresenter::class
        );

        // Service bindings
        $this->app->bind(
            MailServiceInterface::class,
            LaravelMailService::class
        );

        // Interactor bindings
        $this->app->bind(
            CreateBlogPostInteractorInterface::class,
            CreateBlogPostInteractor::class
        );

        $this->app->bind(
            UpdateBlogPostInteractorInterface::class,
            UpdateBlogPostInteractor::class
        );

        $this->app->bind(
            DeleteBlogPostInteractorInterface::class,
            DeleteBlogPostInteractor::class
        );

        $this->app->bind(
            GetBlogPostsInteractorInterface::class,
            GetBlogPostsInteractor::class
        );

        
    }

    private function registerContactInteractors(): void
    {
        $this->app->bind(
            SendContactInteractorInterface::class,
            SendContactInteractor::class
        );
    }

    private function registerProfileInteractors(): void
    {
        $this->app->bind(
            UpdateProfileInteractorInterface::class,
            UpdateProfileInteractor::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
