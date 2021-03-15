<?php

namespace App\Providers;

use App\Repository\Eloquent\CategoryRepository\CategoryInterface\CategoryInterface;
use App\Repository\Eloquent\CategoryRepository\CategoryRepository;
use App\Repository\Eloquent\PostRepository\PostInterface\PostInterface;
use App\Repository\Eloquent\PostRepository\PostRepository;
use App\Repository\Eloquent\TagRepository\TagInterface\TagInterface;
use App\Repository\Eloquent\TagRepository\TagRepository;
use App\Repository\Eloquent\WebRepository\WebInterface\WebInterface;
use App\Repository\Eloquent\WebRepository\WebRepository;
use Illuminate\Pagination\Paginator;
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
        $this->app->bind(WebInterface::class, WebRepository::class);
        $this->app->bind(PostInterface::class, PostRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(TagInterface::class, TagRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
