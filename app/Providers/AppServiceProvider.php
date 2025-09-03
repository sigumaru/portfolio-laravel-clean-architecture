<?php

namespace App\Providers;

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

// Infrastructure Service Implementations
use App\Infrastructure\Services\LaravelMailService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
